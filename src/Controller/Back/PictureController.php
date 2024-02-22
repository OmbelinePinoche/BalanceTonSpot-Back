<?php

namespace App\Controller\Back;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PictureController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/pictures', name: 'list_pictures')]
    public function list(PictureRepository $pictureRepository): Response
    {
        // 1st step is getting all the pictures from the repository
        $pictures = $pictureRepository->findAll();

        return $this->render('back/picture/browse.html.twig', [
            'pictures' => $pictures,
        ]);
    }

    #[Route('/spot/{slug}/pictures', name: 'picture_by_spot')]
    public function listBySpot(SpotRepository $spotRepository, $slug): Response
    {
        // Find the spot with the slug
        $spot = $spotRepository->find(['slug' => $slug]);

        // Check if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Spot non trouvé'], 404);
        }

        // Get the pictures associated to the spot
        $pictures = $spot->getPictures();

        // Check if there are pictures for the requested picture
        if (!$pictures) {
            return $this->json(['message' => 'Aucune image pour le spot sélectionné'], 404);
        }

        // Return the pictures associated to the spot
        return $this->render('back/picture/pictureBySpot.html.twig');
    }

    /**
     * Create a picture with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/admin/picture/new', name: 'add_picture')]
    public function create(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Create an instance for the entity Picture
        $picture = new Picture();
        // Create a form
        $form = $this->createForm(PictureType::class, $picture);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile */
            $pictureFile = $form->get('path')->getData();
            if ($pictureFile) {

                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . bin2hex(random_bytes(8)) . '.' . $pictureFile->guessExtension();

                // Move the file to the directory where pictures are stored
                $pictureFile->move(
                    $this->getParameter('pictures_directory'),
                    $newFilename
                );

                $picture->setPath($newFilename);
            }

            $entityManager->persist($picture);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the picture has been created.
            $this->addFlash(
                'succès',
                "L'image" . $picture->getName() . "a bien été ajoutée !"
            );

            // Return the pictures in the view
            return $this->redirectToRoute('list_pictures');
        }

        return $this->render('back/picture/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a picture via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/picture/edit/{id}', name: 'edit_picture')]
    public function edit(Picture $picture, Request $request, EntityManagerInterface $entityManager): Response
    {
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(PictureType::class, $picture);
        // Here I build a form which manipulates an object $picture which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile */
            $pictureFile = $form->get('path')->getData();
            
            if ($pictureFile !== null) {

                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . bin2hex(random_bytes(8)) . '.' . $pictureFile->guessExtension();

                // Move the file to the directory where pictures are stored
                $pictureFile->move(
                    $this->getParameter('pictures_directory'),
                    $newFilename
                );

                $picture->setName($newFilename);
                $picture->setPath($newFilename);
            }

            $entityManager->persist($picture);
            $entityManager->flush();

            // We will display a 'flash message' which will allow us to display whether or not the picture has been created
            $this->addFlash(
                'succès',
                "L'image" . $picture->getName() . " a bien été modifiée !"
            );
            
            return $this->redirectToRoute('list_pictures');
        }

        // Je passe tous les pictures à ma vue
        return $this->render('back/picture/edit.html.twig', [
            'form' => $form,
            'picture' => $picture
        ]);
    }

    /**
     *  Modify a picture via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/picture/remove/{id}', name: 'remove_picture')]
    public function remove(Picture $picture, EntityManagerInterface $entityManager): Response
    {
        // Here we want delete a picture so no need to create anything

        // Delete the picture
        $entityManager->remove($picture);
        $entityManager->flush();

        // Return user to the home page
        return $this->redirectToRoute('list_pictures');
    }

    #[Route('/tri/{sortBy}', name: 'tri_picture')]
    public function triPicture(PictureRepository $pictureRepository, string $sortBy): Response
    {
        // Define default sorting method if an invalid one is provided
        $validSortOptions = ['nom', 'spot']; // Valid sorting options
        $sortBy = in_array($sortBy, $validSortOptions) ? $sortBy : 'nom';

        // Switch based on sorting method provided
        switch ($sortBy) {
                // If sorting by name
            case 'nom':
                // Retrieve pictures sorted by name
                $pictures = $pictureRepository->findAllOrderedByName();
                break;
                // If sorting by spot
            case 'spot':
                // Retrieve pictures sorted by spot
                $pictures = $pictureRepository->findAllOrderedBySpot();
                break;
                // If invalid sorting option provided, default to sorting by name
            default:
                $pictures = $pictureRepository->findAllOrderedByName();
        }

        // Render the browse.html.twig template with sorted pictures and sorting method
        return $this->render('back/picture/browse.html.twig', [
            'pictures' => $pictures,
            'sortBy' => $sortBy, // Pass the sorting method to the template
        ]);
    }
}
