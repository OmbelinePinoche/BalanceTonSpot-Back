<?php

namespace App\Controller\Api;

use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoritesController extends AbstractController
{
    #[Route('/api/favorites', name: 'api_favorites_list', methods: ['GET'])]
    public function list(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Checks if the user exists
        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Get all the favorites from the User entity
        $favorites = $user->getFavorites();

        // Checks if there are any favorites in the list
        if (count($favorites) == 0) {
            return $this->json(['message' => 'Aucun spot en favoris'], 404);
        }

        // We want to return the favorites to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $favorites,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_favorites_list',]
        );
    }

    #[Route('/api/favorites/{spotId}', name: 'api_add_to_favorites', methods: ['POST'])]
    public function addToFavorites(EntityManagerInterface $entityManager, SpotRepository $spotRepository, $spotId): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Checks if the user exists
        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Retrieve the spot from their ID
        $spot = $spotRepository->find($spotId);

        // Checks if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Spot non trouvé'], 404);
        }

        // Adds a spot in the favorites list
        $user->addFavorite($spot);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'Spot ajouté aux favoris!'], 200);
    }


    #[Route('/api/favorites/{spotId}', name: 'api_remove_favorites', methods: ['DELETE'])]
    public function removefavorite(EntityManagerInterface $entityManager, SpotRepository $spotRepository, $spotId): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Checks if the user exists
        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Retrieve the spot from their ID
        $spot = $spotRepository->find($spotId);

        // Checks if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Spot non trouvé'], 404);
        }

        // Delete the data send in the request 
        $user->removeFavorite($spot);

        $entityManager->flush();

        // Return the success message
        return $this->json(['message' => 'Spot supprimé des favoris!'], 200);
    }
}
