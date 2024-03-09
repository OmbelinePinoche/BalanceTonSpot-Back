<?php

namespace App\Controller\Back;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/pictures')]
class PictureController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/', name: 'list_pictures')]
    public function list(PictureRepository $pictureRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // 1st step is getting all the pictures from the repository
        $pictures = $pictureRepository->findAll();

        $pagination = $paginator->paginate(
            $pictures,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('back/picture/browse.html.twig', [
            'pictures' => $pictures,
            'pagination' => $pagination
        ]);
    }

    /**
     * To create a picture with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/admin/new', name: 'add_picture')]
    public function create(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // We want to create an instance for the entity Picture
        $picture = new Picture();
        // Creates a form
        $form = $this->createForm(PictureType::class, $picture);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile */
            $pictureFile = $form->get('path')->getData();
            if ($pictureFile) {

                // Generates a new filename to avoid potential security issues
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . bin2hex(random_bytes(8)) . '.' . $pictureFile->guessExtension();

                // Gets the current path
                $currentPath = $picture->getPath();

                // Deletes the previous picture if it exists
                if ($currentPath) {
                    $currentFilePath = $this->getParameter('pictures_directory') . '/' . $currentPath;
                    if (file_exists($currentFilePath)) {
                        unlink($currentFilePath);
                    }
                }

                // Moves the file to the directory where pictures are stored
                $pictureFile->move(
                    $this->getParameter('pictures_directory'),
                    $newFilename
                );

                // Sets the new filename in the user entity
                $picture->setPath($newFilename);
            }

            // We need to save the changes in the 
            $entityManager->persist($picture);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the picture has been created.
            $this->addFlash(
                'addpicture',
                "L'image " . $picture->getName() . " a bien été ajoutée !"
            );

            // Returns the pictures in the view
            return $this->redirectToRoute('list_pictures');
        }

        return $this->render('back/picture/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * To modify a picture via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/edit/{id}', name: 'edit_picture')]
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

                // Generates a safe and unique filename for the uploaded file
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . bin2hex(random_bytes(8)) . '.' . $pictureFile->guessExtension();

                // Moves the file to the directory where pictures are stored
                $pictureFile->move(
                    $this->getParameter('pictures_directory'),
                    $newFilename
                );

                // Updates the Picture object with the new filename
                $picture->setName($newFilename);
                $picture->setPath($newFilename);
            }

            // We persist the Picture object to the database
            $entityManager->persist($picture);
            $entityManager->flush();

            // We will display a 'flash message' which will allow us to display whether or not the picture has been updated
            $this->addFlash(
                'updatepicture',
                "L'image " . $picture->getName() . " a bien été modifiée !"
            );

            return $this->redirectToRoute('list_pictures');
        }

        // Renders the form to the view
        return $this->render('back/picture/edit.html.twig', [
            'form' => $form,
            'picture' => $picture
        ]);
    }

    /**
     *  Modify a picture via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/remove/{id}', name: 'remove_picture')]
    public function remove(Picture $picture, EntityManagerInterface $entityManager): Response
    {
        // Here we want delete a picture so no need to create anything

        // Deletes the picture
        $entityManager->remove($picture);
        $entityManager->flush();

        // We will display a 'flash message' which will allow us to display whether or not the picture has been deleted
        $this->addFlash(
            'deletepicture',
            "L'image " . $picture->getName() . " a bien été supprimée !"
        );

        // Returns user to the home page
        return $this->redirectToRoute('list_pictures');
    }

    #[Route('/sort/{sortBy}', name: 'sort_picture')]
    public function sortPicture(PictureRepository $pictureRepository, string $sortBy, Request $request, PaginatorInterface $paginator): Response
    {
        // Defines default sorting method if an invalid one is provided
        $validSortOptions = ['nom', 'spot']; // Valid sorting options
        $sortBy = in_array($sortBy, $validSortOptions) ? $sortBy : 'nom';

        // Switches based on sorting method provided
        switch ($sortBy) {
                // If sorting by name
            case 'nom':
                // Retrieves pictures sorted by name
                $pictures = $pictureRepository->findAllOrderedByName();
                break;
                // If sorting by spot
            case 'spot':
                // Retrieves pictures sorted by spot
                $pictures = $pictureRepository->findAllOrderedBySpot();
                break;
                // If invalid sorting option provided, default to sorting by name
            default:
                $pictures = $pictureRepository->findAllOrderedByName();
        }

        $pagination = $paginator->paginate(
            $pictures,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        // This renders the browse.html.twig template with sorted pictures and sorting method
        return $this->render('back/picture/browse.html.twig', [
            'pictures' => $pictures,
            'sortBy' => $sortBy, // Passes the sorting method to the template
            'pagination' => $pagination
        ]);
    }
}
