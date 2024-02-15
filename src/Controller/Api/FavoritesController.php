<?php

namespace App\Controller\Api;


use App\Entity\Spot;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoritesController extends AbstractController
{
    #[Route('/api/favorites', name: 'api_favorites_list', methods: ['GET'])]
    public function list(User $user): Response
    {
        // 1st step is getting all the favorites from the repository
        $favorites = $user->getFavorites();
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

    #[Route('/api/favorite/{userId}/{spotId}', name: 'api_add_to_favorites', methods: ['POST'])]
    public function addToFavorites(Request $request, EntityManagerInterface $entityManager, $userId, $spotId): Response
    {
        // Retrieves the user from their ID
        $user = $entityManager->getRepository(User::class)->find($userId);

        // Checks if the user exists
        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Retrieve the spot from their ID
        $spot = $entityManager->getRepository(Spot::class)->find($spotId);

        // Checks if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Spot non trouvé'], 404);
        }

        // Adds a spot in the favorites list
        $user->addFavorite($spot);

        $entityManager->persist($spot);
        $entityManager->flush();

        return $this->json(['message' => 'Spot ajouté aux favoris!'], 200);
    }


    #[Route('/api/favorite/{userId}/{spotId}', name: 'api_favorites_delete', methods: ['DELETE'])]
    public function removefavorite(EntityManagerInterface $entityManager, $favoris = null): Response
    {
        // Check if the favoris exists
        if (!$favoris) {

            return $this->json(['message' => 'Aucun favori trouvé'], 404);
        }
        // Delete the data send in the request 
        $entityManager->remove($favoris);
        $entityManager->flush();

        // Return the success message
        return $this->json(['message' => 'favori supprimé avec succès!'], 200);
    }
}
