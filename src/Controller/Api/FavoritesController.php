<?php

namespace App\Controller\Api;


use App\Entity\User;
use App\Form\FileTransformer;
use App\Repository\UserRepository;
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

    #[Route('/api/favorites', name: 'api_list_favorites', methods: ['GET'])]
    public function list(UserRepository $userRepository, User $user): Response
    {
        // 1st step is getting all the users from the repository
        $user = $this->getUser();
        $favoris = $userRepository->findByFavorites($user);
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
            ['groups' => 'api_list_user']
        );
    }

    #[Route('/api/user/{slug}', name: 'api_show_favorites', methods: ['GET'])]
    public function show(userRepository $userRepository, $slug): Response
    {
        // 1st step is getting all the users from the repository
        $user = $userRepository->findOneBy(['slug' => $slug]);

        if (!$user) {
            return $this->json(['message' => 'user non trouvé'], 404);
        }
        // We want to return the users to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json($user,200, [], ['groups' => 'api_show_user']
        );
    }




    
}




 
