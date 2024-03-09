<?php
namespace App\Controller\Api;

use App\Repository\SportRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SportController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/api/sports', name: 'api_list_sport', methods: ['GET'])]
    public function list(SportRepository $sportRepository): Response
    {
        // 1st step is getting all the sports from the repository
        $sports = $sportRepository->findAll();
        // We want to return the sports to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $sports,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_list_sport']
        );
    }

    #[Route('/api/sport/{slug}', name: 'api_show_sport', methods: ['GET'])]
    public function show(SportRepository $sportRepository, $slug): Response
    {
        // 1st step is getting all the sports from the repository
        $sport = $sportRepository->findOneBy(['slug' => $slug]);

        if (!$sport) {
            return $this->json(['message' => 'Sport non trouvé'], 404);
        }
        // We want to return the sports to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json($sport,200, [], ['groups' => 'api_show_sport']
        );
    }

    #[Route('/api/sport/{slug}/spots', name: 'api_show_by_sport', methods: ['GET'])]
    public function listBySport($slug, SportRepository $sportRepository): Response
    {
        // Finds the sport with the slug
        $sport = $sportRepository->findOneBy(['slug' => $slug]);

        // Checks if the sport exists
        if (!$sport) {
            return $this->json(['message' => 'Sport non trouvé'], 404);
        }

        // Gets the spots associated with the sport
        $spots = $sport->getSpotId();

        // Checks if there are spots for the requested sport
        if (!$spots) {
            return $this->json(['message' => 'Aucun spot trouvé dans la catégorie sélectionnée'], 404);
        }

        // Returns the spots associated with the sport
        return $this->json($spots, 200, [], ['groups' => 'api_show_by_sport']);
    }

}



