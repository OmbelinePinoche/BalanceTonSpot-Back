<?php

namespace App\Controller\Api;

use App\Repository\PictureRepository;
use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PictureController extends AbstractController
{
    #[Route('/api/pictures', name: 'api_list_pictures', methods: ['GET'])]
    public function list(PictureRepository $pictureRepository): Response
    {
        // 1st step is getting all the pictures from the repository
        $pictures = $pictureRepository->findAll();
        // We want to return the pictures to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $pictures,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_list_pictures']
        );
    }

    #[Route('/api/spot/{slug}/pictures', name: 'api_picture_by_spot', methods: ['GET'])]
    public function listBySpot(SpotRepository $spotRepository, $slug): Response
    {
        // Finds the spot with the slug
        $spot = $spotRepository->findOneBy(['slug' => $slug]);

        // Checks if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Spot non trouvé'], 404);
        }

        // Gets the pictures associated with the spot
        $pictures = $spot->getPictures();

        // Checks if there are pictures for the requested spot
        if (!$pictures) {
            return $this->json(['message' => 'Aucune image pour le spot sélectionné'], 404);
        }

        // Returns the pictures associated with the spot
        return $this->json($pictures, 200, [], ['groups' => 'api_picture_by_spot']);
    }

}
