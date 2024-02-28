<?php

namespace App\Controller\Back;

use App\Entity\Sport;
use App\Form\SportType;
use App\Repository\LocationRepository;
use App\Repository\SportRepository;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/sports')]
class SportController extends AbstractController
{
    /**
     * Shows all sports in the backoffice
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
     * To create a sport with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/admin/new', name: 'add_sport')]
    public function create(Request $request, EntityManagerInterface  $entityManager, SluggerInterface $slugger): Response
    {
        // Create an instance for the entity sport
        $sport = new Sport();
        // Create a form
        $form = $this->createForm(SportType::class, $sport);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            // Uses the sport name by default if "name" field is available
            $slug = $form->get('name')->getData() ?? '';
            // Generates the slug using the Slugger service
            $slug = $slugger->slug($slug);
            $sport->setSlug($slug);

            $entityManager->persist($sport);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the sport has been created.
            $this->addFlash(
                'addsport',
                'Le sport ' . $sport->getName() . ' a bien été créé !'
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
    #[Route('/admin/edit/{slug}', name: 'edit_sport')]
    public function edit(sport $sport, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(SportType::class, $sport);
        // Here I build a form which manipulates an object $sport which already exists

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Here, no need to persist because it already exists so no need to recreate it 

            $entityManager->flush();

            /*   We will display a 'flash message' which will allow us to display whether or not the sport has been updated. */
            $this->addFlash(
                'updatesport',
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
    #[Route('/admin/remove/{id}', name: 'remove_sport')]
    public function remove(sport $sport, SportRepository $SportRepository, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here we want delete a sport so no need to create anything.

        // Deletes the sport
        $entityManager->remove($sport);
        $entityManager->flush();

        /*   We will display a 'flash message' which will allow us to display whether or not the sport has been deleted. */
        $this->addFlash(
            'deletesport',
            'Le sport ' . $sport->getName() . ' a bien été supprimé !'
        );

        // Returns user to the sport list
        return $this->redirectToRoute('list_sport');
    }


    #[Route('/{slug}/spots', name: 'show_by_sport', methods: ['GET'])]
    public function showBySport(SpotRepository $spotRepository, SportRepository $sportRepository, LocationRepository $locationRepository, $slug, Request $request, PaginatorInterface $paginator)
    {
        // Finds all the sports for the loop {% for sport in sports %} to work
        $sports = $sportRepository->findAll();
        // Finds the sport based on the provided slug
        $sport = $sportRepository->findOneBy(['slug' => $slug]);

        // Checks if the sport was found
        if (!$sport) {
            return $this->json(['message' => 'Aucun sport n\'a été trouvé pour le slug donné'], 404);
        }

        // We need to search the spots associated with the sport
        $spots = $spotRepository->findBySport($sport);

        $pagination = $paginator->paginate(
            $spots,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        // Fetches all locations
        $locations = $locationRepository->findAll();

        // Returns to the view all the spots according to the sport
        return $this->render('back/spot/browse.html.twig', [
            'spots' => $spots,
            'sport' => $sport,
            'locations' => $locations,
            'sports' => $sports,
            'pagination' => $pagination
        ]);
    }

    #[Route('/sort/{sortBy}', name: 'sort_sport')]
    public function triSport(SportRepository $sportRepository, string $sortBy): Response
    {
        // Defines default sorting method if an invalid one is provided
        $validSortOptions = ['nom', 'spot'];
        $sortBy = in_array($sortBy, $validSortOptions) ? $sortBy : 'nom';

        // Switch based on sorting method provided
        switch ($sortBy) {
                // If sorting by name
            case 'nom':
                // Retrieves pictures sorted by name
                $sports = $sportRepository->findAllOrderedByName();
                break;
            case 'spot':
                // Retrieves pictures sorted by spot
                $sports = $sportRepository->findAllOrderedBySpot();
                break;
                // If invalid sorting option provided, default to sorting by name
            default:
                $sports = $sportRepository->findAllOrderedByName();
        }
        // Returns the sports according to the chosen order
        return $this->render('back/sport/browse.html.twig', [
            'sports' => $sports,
            'sortBy' => $sortBy,
        ]);
    }
}
