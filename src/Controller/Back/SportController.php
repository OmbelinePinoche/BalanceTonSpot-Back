<?php

namespace App\Controller\Back;

use App\Entity\Sport;
use App\Form\SportType;
use App\Repository\LocationRepository;
use App\Repository\SportRepository;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/sports')]
class SportController extends AbstractController
{
    /**
     * Shows all sports in the backoffice
     * Don't forget that the route above ('/back/sport') will be the start of all the routes created below
     * @return Response
     */
    #[Route('/', name: 'list_sport')]
    public function browse(SportRepository $SportRepository): Response
    {
        // 1st step is getting all the sports from the repository
        $sports = $SportRepository->findAll();

        return $this->render('back/sport/browse.html.twig', [
            'sports' => $sports,
        ]);
    }

    /**
     *  Shows a sport by ID in the backoffice
     *  Don't forget that the route above ('/back/sport') will be the start of all the routes created below
     *
     * @return Response
     */
    #[Route('/show/{slug}', name: 'show_sport')]
    public function show(SportRepository $SportRepository,  $id): Response
    {
        // Get the sport by its ID
        $sport = $SportRepository->find($id);

        // Checks if the sport exists
        if (!$sport) {
            throw $this->createNotFoundException('Aucun sport ne répond à cet ID!');
        }

        // Return all the sport in the view
        return $this->render('back/sport/show.html.twig', [
            'sport' => $sport,
        ]);
    }

    /**
     * Create a sport with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/new', name: 'add_sport')]
    public function create(Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Create an instance for the entity sport
        $sport = new Sport();
        // Create a form
        $form = $this->createForm(SportType::class, $sport);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sport);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the sport has been created.
            $this->addFlash(
                'succès',
                'Le sport ' . $sport->getName() . 'a bien été créé !'
            );

            // Return the sports in the view
            return $this->redirectToRoute('list_sport');
        }

        return $this->render('back/sport/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a sport via its ID in a form in the back office
     * @return Response
     */
    #[Route('/edit/{slug}', name: 'edit_sport')]
    public function edit(sport $sport, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here we want to edit a sport so no need to create anything.
        /*    The sport exists already */
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(SportType::class, $sport);
        // Here I build a form which manipulates an object $sport which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Here, no need to persist because it already exists so no need to recreate it 

            $entityManager->flush();

            /*   We will display a 'flash message' which will allow us to display whether or not the sport has been created. */
            $this->addFlash(
                'succès',
                'Le sport ' . $sport->getName() . ' a bien été modifié !'
            );

            // I return all the sports in the view
            return $this->redirectToRoute('list_sport');
        }
        return $this->render('back/sport/edit.html.twig', [
            'form' => $form,
            'sport' => $sport
        ]);
    }

    /**
     *  Modify a sport via its ID in a form in the back office
     * @return Response
     */
    #[Route('/remove/{id}', name: 'remove_sport')]
    public function remove(sport $sport, SportRepository $SportRepository, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here we want delete a sport so no need to create anything.

        // Delete the sport
        $entityManager->remove($sport);
        $entityManager->flush();

        // Return user to the home page
        return $this->redirectToRoute('list_sport');
    }

    #[Route('/{slug}/spots', name: 'spot_by_sport', methods: ['GET'])]
    public function showBySport(SpotRepository $spotRepository, SportRepository $sportRepository, LocationRepository $locationRepository, Sport $sport, $slug)
    {
        // Checks if the given id sport exists
        if (!$sport) {
            return $this->json(['message' => 'Aucun sport n\'a été trouvé'], 404);
        }

        // Search the spots from the repository with the param "sport"
        $spots = $spotRepository->findBy(['sport_id' => $sport]);
        $locations = $locationRepository->findAll();
        // Get all the sports
        $sports = $sportRepository->findAllBy(['slug' => $slug]);

        // Return  to the view all the spots according to the sport
        return $this->render('back/spot/browse.html.twig', [
            'spots' => $spots,
            'sports' => $sports,
            'sport_id' => $sport,
            'locations' => $locations,
        ]);
    }
}
