<?php

namespace App\Controller\Back;

use App\Entity\Spot;
use App\Form\SpotType;
use App\Entity\Location;
use App\Repository\SpotRepository;
use App\Repository\SportRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\String\Slugger\SluggerInterface;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\File\File;
=======
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
>>>>>>> newbackoffice

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
    public function browse(SpotRepository $spotRepository, LocationRepository $locationRepository, SportRepository $sportRepository): Response
    {
        // 1st step is getting all the spots from the repository
        $spots = $spotRepository->findAll();
        // Also all the locations
        $locations = $locationRepository->findAll();
        // And all the sports
        $sports = $sportRepository->findAll();

        return $this->render('back/spot/browse.html.twig', [
            'spots' => $spots,
            'locations' => $locations,
            'sports' => $sports
        ]);

        

    }

    

    /**
     *  Shows a spot by ID in the backoffice
     *  Don't forget that the route above ('/back/spot') will be the start of all the routes created below
     *
     * @return Response
     */
    #[Route('/show/{slug}', name: 'show')]
    public function show(SpotRepository $spotRepository, $slug): Response
    {
        // Get the spot by its slug
        $spot = $spotRepository->findOneBy(['slug' => $slug]);

        // Checks if the spot exists
        if (!$spot) {
            throw $this->createNotFoundException('Aucun spot ne répond à cet ID!');
        }

        // Return all the spot in the view
        return $this->render('back/spot/show.html.twig', [
            'spot' => $spot,
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
    public function edit(Spot $spot, Request $request, EntityManagerInterface  $entityManager): Response
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

            $entityManager->persist($spot);
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