<?php

namespace App\Controller\Back;

use App\Entity\Spot;
use App\Form\SpotType;
use App\Repository\SpotRepository;
use App\Repository\SportRepository;
use App\Repository\LocationRepository;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Knp\Component\Pager\PaginatorInterface;

class SpotController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * Shows all spots in the backoffice
     * Don't forget that the route above ('/back/spot') will be the start of all the routes created below
     * @return Response
     */
    #[Route('/', name: 'list')]
    public function browse(SpotRepository $spotRepository, LocationRepository $locationRepository, SportRepository $sportRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // 1st step is getting all the spots from the repository
        $spots = $spotRepository->findAll();
        // Also all the locations
        $locations = $locationRepository->findAll();
        // And all the sports
        $sports = $sportRepository->findAll();

        $pagination = $paginator->paginate(
            $spots,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('back/spot/browse.html.twig', [
            'spots' => $spots,
            'locations' => $locations,
            'sports' => $sports, 
            'pagination' => $pagination
        ]);
    }

    /**
     *  Shows a spot by ID in the backoffice
     *  Don't forget that the route above ('/back/spot') will be the start of all the routes created below
     *
     * @return Response
     */
    #[Route('/show/{slug}', name: 'show')]
    public function show(SpotRepository $spotRepository, $slug, PictureRepository $pictureRepository): Response
    {
        // Gets the spot by its slug
        $spot = $spotRepository->findOneBy(['slug' => $slug]);

        // Checks if the spot exists
        if (!$spot) {
            throw $this->createNotFoundException('Aucun spot associé à cet ID!');
        }

        // Gets the pictures according to the spot
        $pictures = $pictureRepository->findBy(['spot' => $spot]);

        // Gets all the spots
        $spots = $spotRepository->findAll();

        // Determines the current index of the spot in the spot array
        $currentIndex = null;
        foreach ($spots as $index => $currentSpot) {
            // Checks if the id of the current spot matches the id of the target spot
            if ($currentSpot->getId() === $spot->getId()) {
                // If there is a match, set $currentIndex as the index of the current spot in the array
                $currentIndex = $index;
            }
        }

        // Total of the spots in the spot array
        $spotsCount = count($spots);

        // Return all the spots in the view
        return $this->render('back/spot/show.html.twig', [
            'spot' => $spot, 'pictures' => $pictures, 'spots' => $spots, 'currentIndex' => $currentIndex,  'spotsCount' => $spotsCount,
        ]);
    }

    /**
     * Create a spot with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/admin/new', name: 'add')]
    public function create(Request $request, EntityManagerInterface  $entityManager, SluggerInterface $slugger): Response
    {
        // Create an instance for the entity spot
        $spot = new Spot();

        // Create a form
        $form = $this->createForm(SpotType::class, $spot);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {

                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . bin2hex(random_bytes(8)) . '.' . $pictureFile->guessExtension();

                // Move the file to the directory where pictures are stored
                $pictureFile->move(
                    $this->getParameter('pictures_directory'),
                    $newFilename
                );

                $spot->setPicture($newFilename);
            }

            // Generate the slug using the Slugger service
            $slug = $form->get('name')->getData() ?? ''; // Use the spot name by default if "name" field is available
            $slug = $slugger->slug($slug);
            $spot->setSlug($slug);

            $entityManager->persist($spot);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the spot has been created.
            $this->addFlash(
                'succès',
                'Le spot ' . $spot->getName() . ' a bien été créé !'
            );

            // Return the spots in the view
            return $this->redirectToRoute('list');
        }

        return $this->render('back/spot/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a spot via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/edit/{slug}', name: 'edit')]
    public function edit(Spot $spot, Request $request, EntityManagerInterface  $entityManager, ParameterBagInterface $params): Response
    {
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(SpotType::class, $spot);
        // Here I build a form which manipulates an object $spot which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile !== null) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . bin2hex(random_bytes(8)) . '.' . $pictureFile->guessExtension();

                // Set the new filename in the spot entity
                $spot->setPicture($newFilename);

                // Get the current picture path
                $currentPath = $spot->getPicture();

                // Delete the previous picture path if it exists
                if ($currentPath) {
                    $currentFilePath = $this->getParameter('pictures_directory') . '/' . $currentPath;
                    if (file_exists($currentFilePath)) {
                        unlink($currentFilePath);
                    }
                }

                // Move the file to the directory where pictures are stored
                $pictureFile->move(
                    $this->getParameter('pictures_directory'),
                    $newFilename
                );

                $spot->setPicture($newFilename);
            }

            $entityManager->flush();

            // We will display a 'flash message' which will allow us to display whether or not the spot has been created
            $this->addFlash(
                'succès',
                'Le spot ' . $spot->getName() . ' a bien été modifié !'
            );
            return $this->redirectToRoute('list');
        }

        // Je passe tous les spots à ma vue
        return $this->render('back/spot/edit.html.twig', [
            'form' => $form,
            'spot' => $spot
        ]);
    }

    /**
     *  Modify a spot via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/remove/{id}', name: 'remove')]
    public function remove(Spot $spot, EntityManagerInterface  $entityManager): Response
    {
        // Here we want delete a spot so no need to create anything

        // Delete the spot
        $entityManager->remove($spot);
        $entityManager->flush();

        // Return user to the home page
        return $this->redirectToRoute('list');
    }
}
