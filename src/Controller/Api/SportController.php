<?php
namespace App\Controller\Api;

use App\Entity\Spot;
use App\Entity\Sport;
use App\Entity\Location;
use App\Repository\SpotRepository;
use App\Repository\SportRepository;
use App\Repository\LocationRepository;
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
        // Find the sport with the slug
        $sport = $sportRepository->findOneBy(['slug' => $slug]);

        // Check if the sport exists
        if (!$sport) {
            return $this->json(['message' => 'Sport non trouvé'], 404);
        }

        // Get the spots associated with the sport
        $spots = $sport->getSpotId();

        // Check if there are spots for the requested sport
        if (!$spots) {
            return $this->json(['message' => 'Aucun spot trouvé dans la catégorie sélectionnée'], 404);
        }

        // Return the spots associated with the sport
        return $this->json($spots, 200, [], ['groups' => 'api_show_by_sport']);
    }
   
    #[Route('/api/location/{slug}/spots/snowboard', name: 'api_snow_spot_by_location', methods: ['GET'])]
    public function listSnow(SpotRepository $spotRepository, $slug, LocationRepository $locationRepository): Response
    {
        // Find the location with the slug
        $location = $locationRepository->findOneBy(['slug' => $slug]);

        // Checks if the location exists
        if (!$location) {
            return $this->json(['message' => 'Localisation inconnue!'], 404);
        }

        //  Get the snow spots associated to the location
        $snowSpot = $spotRepository->getSnowSpotsByLocation($location);

        // Checks if any snow spots are found
        if (!$snowSpot) {
            return $this->json(['message' => 'Aucun spot de snowboard trouvé dans la localisation demandée'], 404);
        }

        //  Return the snow spots associated to the location
        return $this->json($snowSpot, 200, [], ['groups' => 'api_snow_spot_by_location']);
    }

    #[Route('/api/location/{slug}/spots/skateboard', name: 'api_skate_spot_by_location', methods: ['GET'])]
    public function listSkate(SpotRepository $spotRepository, $slug, LocationRepository $locationRepository): Response
    {
        // Find the location with the slug
        $location =$locationRepository->findOneBy(['slug' => $slug]);

        // Checks if the location exists
        if (!$location) {
            return $this->json(['message' => 'Localisation inconnue!'], 404);
        }

        // Get the skate spots associated to the location
        $skateSpot = $spotRepository->getSkateSpotsByLocation($location);

        // Checks if any skate spots are found
        if (!$skateSpot) {
            return $this->json(['message' => 'Aucun spot de skateboard trouvé dans la localisation demandée'], 404);
        }

        // Return the skate spots associated to the location
        return $this->json($skateSpot, 200, [], ['groups' => 'api_skate_spot_by_location']);
    }

}

   



