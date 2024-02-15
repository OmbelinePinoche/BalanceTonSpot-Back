<?php

namespace App\Controller\Api;


use App\Entity\Spot;
use App\Entity\User;
use App\Form\FileTransformer;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoritesController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/api/favoris', name: 'api_list_favorites', methods: ['GET'])]
    public function list(UserRepository $userRepository, User $user): Response
    {
        // 1st step is getting all the users from the repository
        $favoris = $user->getFavorites();
        // We want to return the users to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $favoris,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_list_favorites',]
        );
    }

   

    #[Route('/api/favori/{userId}/{spotId}', name: 'api_update_favorites', methods: ['POST'])]
    public function updateFavorite(Request $request, EntityManagerInterface $entityManager, $userId, $spotId): Response
    {
        // Retrieve the user from their ID
        $user = $entityManager->getRepository(User::class)->find($userId);

        // Check if the user exists
        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Retrieve the spot from their ID
        $spot = $entityManager->getRepository(Spot::class)->find($spotId);

        // Check if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Spot non trouvé'], 404);
        }

        
            // add a favorite in the list
            $user->addFavorite($spot);
            $message = 'Favori ajouté avec succès.';
        

        $entityManager->flush();

        return $this->json(['message' => $message], 200);
    }


    #[Route('/api/favori/{userId}/{spotId}', name: 'api_favorites_delete', methods: ['DELETE'])]
    public function removefavorites(EntityManagerInterface $entityManager, $favoris = null): Response
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




 
