<?php

namespace App\Controller\Api;

use App\Entity\Location;
use App\Entity\Sport;
use App\Entity\Spot;
use App\Repository\LocationRepository;
use App\Repository\SportRepository;
use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class SpotController extends AbstractController
{
    #[Route('/api/spots', name: 'list_spot', methods: ['GET'])]
    public function list(SpotRepository $spotRepository): Response
    {
        // 1st step is getting all the spots from the repository
        $spots = $spotRepository->findAll();
        // We want to return the spots to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $spots,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'list_spot']
        );
    }

    #[Route('/api/location/{id}/spots', name: 'spot_by_location', methods: ['GET'])]
    public function listByLocation(SpotRepository $spotRepository, Spot $spot, Location $location = null): Response
    {
        if (!$spot) {
            return $this->json(['message' => 'Aucun spot trouvé'], 404);
        }
        // Get the spots from the repository searching by the param "location"
        $spotByLocation = $spotRepository->findBy(['location' => $location]);

        // Return all the spots according to the location
        return $this->json($spotByLocation, 200, [], ['groups' => 'spot_by_location']);
    }

    // #[Route('/api/location/{id}/spots/snowboard', name: 'snow_spot_by_location', methods: ['GET'])]
    // public function listSnowByLocation(int $id, SpotRepository $spotRepository, Spot $spot, $sport_id, LocationRepository $locationRepository, Location $location = null): Response
    // {
    //     // // Get the location from the repository
    //     // $location = $locationRepository->find($id);

    //     // We check if the location exists
    //     if (!$location) {
    //         return $this->json(['message' => 'Lieu non trouvé.'], 404);
    //     }

    //     // Get snow spots associated to the given location 
    //     $snowSpots = $spotRepository->getSnowSpotsByLocation($location);

    //     // Checks if the spots are found 
    //     if (!$snowSpots) {
    //         return $this->json(['message' => 'Aucun spot n\a été trouvé!'], 404);
    //     }

    //     // Return the snow spots
    //     return $this->json($snowSpots, 200, [], ['groups' => 'snow_spot_by_location']);
    // }

    #[Route('/api/sport/{id}/spots', name: 'show_by_sport', methods: ['GET'])]
    public function listBySport(Sport $sport = null): Response
    {
        // Get the spots from the entity Sport 
        $spots = $sport->getSpotId();
        
        // Checks if there is a spot in the requested sport
        if (!$spots) {
            return $this->json(['message' => 'Aucun spot n\'a été trouvé!'], 404);
        }
        // Return the spots by sport type
        return $this->json($spots, 200, [], ['groups' => 'show_by_sport']);
    }
    
    #[Route('/api/spot/{id}', name: 'show', methods: ['GET'])]
    public function show(SpotRepository $spotRepository, $id): Response
    {
        $spot = $spotRepository->find($id);

        if (!$spot) {
            return $this->json(['message' => 'Aucun spot n\a été trouvé!'], 404);
        }

        return $this->json($spot, 200, [], ['groups' => 'show']);
    }
}
