<?php

namespace App\Controller\Back;

use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\SpotRepository;
use App\Repository\SportRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/location')]
class LocationController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    /**
     * Shows all locations in the backoffice
     * @return Response
     */
    #[Route('/', name: 'list_location')]
    public function browse(LocationRepository $LocationRepository, SpotRepository $spotRepository): Response
    {
        // 1st step is getting all the locations from the repository
        $locations = $LocationRepository->findAll();
        $spots = $spotRepository->findAll();
        $sortedLocationsByName = $LocationRepository->findAllOrderedByName();

        return $this->render('back/location/browse.html.twig', [
            'locations' => $locations, 'spots' => $spots, 'sortedLocationsByName' => $sortedLocationsByName,

        ]);
    }


    /**
     * To create a location with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/admin/new', name: 'add_location')]
    public function create(Request $request, EntityManagerInterface  $entityManager, SluggerInterface $slugger): Response
    {
        // We need to create an instance for the entity location
        $location = new Location();
        // Creates a form
        $form = $this->createForm(LocationType::class, $location);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // This checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $form->get('name')->getData() ?? ''; // Use the location name by default if "name" field is available

            // Generates the slug using the Slugger service
            $slug = $slugger->slug($slug);
            $location->setSlug($slug);

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

            // Return all the locations in the view
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

        // Deletes the location
        $entityManager->remove($location);
        $entityManager->flush();

        // Returns user to the location list
        return $this->redirectToRoute('list_location');
    }

    #[Route('/{slug}/spots', name: 'show_by_location', methods: ['GET'])]
    public function showByLocation(SpotRepository $spotRepository, SportRepository $sportRepository, LocationRepository $locationRepository, Location $location = null, Request $request, PaginatorInterface $paginator)
    {
        // Checks if the given id location exists
        if (!$location) {
            return $this->json(['message' => 'Aucun emplacement n\'a été trouvé'], 404);
        }
        // Gets all the locations
        $locations = $locationRepository->findAll();
        // We want to search the spots from the repository with the param "location"
        $spots = $spotRepository->findBy(['location' => $location]);
        $sports = $sportRepository->findAll();

        $pagination = $paginator->paginate(
            $spots,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        // Returns to the view all the spots according to the location
        return $this->render('back/spot/browse.html.twig', [
            'spots' => $spots,
            'sports' => $sports,
            'location' => $location,
            'locations' => $locations,
            'pagination' => $pagination
        ]);
    }

    #[Route('/tri/{sortBy}', name: 'tri_location')]
    public function triLocation(LocationRepository $locationRepository, string $sortBy): Response
    {
        // Defines default sorting method if an invalid one is provided
        $validSortOptions = ['name', 'spot'];
        $sortBy = in_array($sortBy, $validSortOptions) ? $sortBy : 'name';

        // We want to fetch locations based on the chosen sorting method
        if ($sortBy === 'name') {
            $locations = $locationRepository->findAllOrderedByName();
        } elseif ($sortBy === 'spot') {
            $locations = $locationRepository->findAllOrderedBySpotCount();
        }
        // Returns the sports according to the chosen order
        return $this->render('back/location/browse.html.twig', [
            'locations' => $locations,
            'sortBy' => $sortBy,
        ]);
    }
}
