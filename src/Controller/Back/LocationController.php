<?php

namespace App\Controller\Back;

use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\SpotRepository;
use App\Repository\SportRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/location')]
class LocationController extends AbstractController
{
    /**
     * Shows all locations in the backoffice
     * @return Response
     */
    #[Route('/', name: 'list_location')]
    public function browse(LocationRepository $LocationRepository, SpotRepository $spotRepository): Response
    {
        // 1st step is getting all the locations from the repository
        $location = $LocationRepository->findAll();
        $spots = $spotRepository->findAll();
        return $this->render('back/location/browse.html.twig', [
            'location' => $location, 'spots' => $spots
        ]);
    }

    /**
     * Create a location with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/admin/new', name: 'add_location')]
    public function create(Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Create an instance for the entity location
        $location = new Location();
        // Create a form
        $form = $this->createForm(LocationType::class, $location);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        //checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($location);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the location has been created.
            $this->addFlash(
                'succès',
                'La ville' . $location->getName() . 'a bien été créée !'
            );
            return $this->redirectToRoute('list_location');
        }

        // Return the locations in the view
        return $this->render('back/location/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a location via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/edit/{slug}', name: 'edit_location')]
    public function edit(location $location, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here we want to edit a location so no need to create anything.
        /*    The location exists already */
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(LocationType::class, $location);
        // Here I build a form which manipulates an object $location which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Here, no need to persist because it already exists so no need to recreate it 

            $entityManager->flush();

            /*   We will display a 'flash message' which will allow us to display whether or not the location has been created. */
            $this->addFlash(
                'succès',
                'La ville' . $location->getName() . ' a bien été modifiée !'
            );

            // I return all the locations in the view
            return $this->redirectToRoute('list_location');
        }

        return $this->render('back/location/edit.html.twig', [
            'form' => $form,
            'location' => $location
        ]);
    }

    /**
     *  Modify a location via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/remove/{id}', name: 'remove_location')]
    public function remove(location $location, LocationRepository $LocationRepository, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here we want delete a location so no need to create anything.

        // Delete the location
        $entityManager->remove($location);
        $entityManager->flush();

        // Return user to the home page
        return $this->redirectToRoute('list_location');
    }

    #[Route('/{slug}/spots', name: 'show_by_location', methods: ['GET'])]
    public function showByLocation(SpotRepository $spotRepository, SportRepository $sportRepository, LocationRepository $locationRepository, Location $location = null)
    {
        // Checks if the given id location exists
        if (!$location) {
            return $this->json(['message' => 'Aucun emplacement n\'a été trouvé'], 404);
        }
        // Get all the locations
        $locations = $locationRepository->findAll();
        // Search the spots from the repository with the param "location"
        $spots = $spotRepository->findBy(['location' => $location]);
        $sports = $sportRepository->findAll();

        // Return  to the view all the spots according to the location
        return $this->render('back/spot/browse.html.twig', [
            'spots' => $spots,
            'sports' => $sports,
            'location' => $location,
            'locations' => $locations,
        ]);
    }

    
#[Route('/select', name: 'choose_location')]
public function select(Request $request, LocationRepository $locationRepository, SportRepository $sportRepository): Response
{
    // Create the form
    $form = $this->createFormBuilder()
        ->add('location', EntityType::class, [
            'class' => Location::class,
            'query_builder' => function (LocationRepository $locationRepository) {
                return $locationRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
            },
            'choice_label' => 'name', // Define which property of the Location entity will be displayed in the select options
            'placeholder' => 'Choose a location', // Optional: Add a placeholder
        ])
        ->getForm();

    // Handle form submission
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Get the selected location
        $selectedLocation = $form->get('location')->getData();

        // Fetch spots associated with the selected location
        $spots = $selectedLocation->getSpots();

        // Render a template to display spots
        return $this->render('back/location/show_spots_by_location.html.twig', [
            'selectedLocation' => $selectedLocation,
            'spots' => $spots,
        ]);
    }

    // Render the form
    return $this->render('back/location/select.html.twig', [
        'form' => $form->createView(),
    ]);
}
}