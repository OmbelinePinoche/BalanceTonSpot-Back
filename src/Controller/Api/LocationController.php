<?php

namespace App\Controller\Api;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Form\FileTransformer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocationController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/api/locations', name: 'api_list_location', methods: ['GET'])]
    public function list(LocationRepository $locationRepository): Response
    {
        // 1st step is getting all the locations from the repository
        $locations = $locationRepository->findAll();
        // We want to return the locations to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $locations,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_list_location']
        );
    }

    #[Route('/api/location/{slug}', name: 'api_show_location', methods: ['GET'])]
    public function show(LocationRepository $locationRepository, $slug): Response
    {
        // 1st step is getting all the locations from the repository
        $location = $locationRepository->findOneBy(['slug' => $slug]);

        if (!$location) {
            return $this->json(['message' => 'location non trouvé'], 404);
        }
        // We want to return the locations to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json($location,200, [], ['groups' => 'api_show_location']
        );
    }
}
