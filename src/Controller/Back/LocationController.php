<?php

namespace App\Controller\Back;

use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class LocationController extends AbstractController
{
    /**
     * Shows all locations in the backoffice
     * Don't forget that the route above ('/back/location') will be the start of all the routes created below
     * @return Response
     */
    #[Route('/', name: 'list_location')]
    public function browse(LocationRepository $LocationRepository): Response
    {
        // 1st step is getting all the locations from the repository
        $locations = $LocationRepository->findAll();
       
        return $this->render('back/location/browse.html.twig', [
            'locations' => $locations,
        ]);
    }

    /**
     *  Shows a location by ID in the backoffice
     *  Don't forget that the route above ('/back/location') will be the start of all the routes created below
     *
     * @return Response
     */
    #[Route('/show/{id}', name: 'show_location')]
    public function show(LocationRepository $LocationRepository, $location,  $id): Response
    {
        // Get the location by his ID
        $location = $LocationRepository->find($id);
        
        // Return all the location in the view
        return $this->render('back/location/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * Create a location with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/create', name: 'create_location')]
    public function create(Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Create a instance for the entity location
        
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
                'La représentation visuelle '.$location->getName().'a bien été créée !'
            );
            return $this->redirectToRoute('browse_location');
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
    #[Route('/edit/{id}', name: 'edit_location')]
    public function edit(location $location, Request $request, EntityManagerInterface  $entityManager): Response
    {
         // Here , we want edit a location so no need to create anything.
     /*    The location exists already */
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(LocationType::class, $location);
        // Here I build a form which manipulates an object $location which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
           // Here, no need to persist because it already exists so no need to recreate it 
        
            $entityManager->flush(); 

          /*   We will display a 'flash message' which will allow us to display whether or not the location has been created. */
            $this->addFlash(
                'succès',
                'La représentation visuelle '.$location->getName().' a bien été modifié !'
            );
            return $this->redirectToRoute('browse_location');
        }
        // Je passe tous les locations à ma vue
        return $this->render('back/location/edit.html.twig', [
            'form' => $form,
            'location' => $location
        ]);
    }

    /**
     *  Modify a location via its ID in a form in the back office
     * @return Response
     */
    #[Route('/remove/{id}', name: 'remove_location')]
    public function remove(location $location, LocationRepository $LocationRepository, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here , we want delete a location so no need to create anything.
     /*    The location exists already */

        // Delete the location
        $entityManager->remove($location);
        $entityManager->flush();
        
        // Return user to the home page
        return $this->redirectToRoute('browse_location');
    }
}
