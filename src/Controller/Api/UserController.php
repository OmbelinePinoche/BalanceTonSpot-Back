<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'api_user_list', methods: ['GET'])]
    public function list(UserRepository $userRepository): Response
    {
        // 1st step is getting all the users from the repository
        $users = $userRepository->findAll();
        // We want to return the users to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $users,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_user_list']
        );
    }

    #[Route('/api/user', name: 'api_show_user', methods: ['GET'])]
    public function show(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['message' => 'Aucun user n\a été trouvé!'], 404);
        }

        return $this->json($user, 200, [], ['groups' => 'api_show_user']);
    }

    #[Route('/api/users', name: 'api_add_user', methods: ['POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPseudo($data['pseudo']);

        // Hash password
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Define the user role
        $user->setRoles($data['roles']);

        // We need to persist the user entity to the database to save the data
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'Utilisateur créé avec succès'], 201);
    }

    #[Route('/api/user', name: 'api_edit_user', methods: ['PUT'])]
    public function update(User $user, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Check if the user exists
        if (!$user) {
            // If not, send the message
            return $this->json(['message' => 'Aucun user n\a été trouvé!'], 404);
        }

        // Retrieve the data send in the request PUT
        $data = $request->getContent();

        $updatedUser = $serializer->deserialize($data, User::class, 'json', ['object_to_populate' => $user]);

        $entityManager->flush();

        // Return to the updated user
        return $this->json(['message' => 'Utilisateur modifié avec succès!'], 200);
    }

    #[Route('/api/user', name: 'api_delete_user', methods: ['DELETE'])]
    public function delete(User $user = null, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Check if the user exists
        if (!$user) {
            return $this->json(['message' => 'Aucun utilisateur n\'a été trouvé'], 404);
        }
        // Delete the data send in the request 
        $entityManager->remove($user);
        $entityManager->flush();

        // Return the success message
        return $this->json(['message' => 'Utilisateur supprimé avec succès!'], 200);
    }

    #[Route('/api/profile/upload', name: 'api_profile_upload',  methods: ['POST'])]
    public function uploadProfilePicture(Request $request, ParameterBagInterface $params, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Check if the user exists
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur introuvable');
        }
        
        // Retrieve the uploaded file named 'profilPictureFile' from the files sent in the HTTP request
        $pictureFile = $request->files->get('profilPictureFile');

        // Check if a file was sent in the request
        if (!$pictureFile) {
            return $this->json([
                'error' => 'Aucun fichier envoyé'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Move the file to the directory where pictures are stored
        $newFilename = uniqid() . '.' . $pictureFile->getClientOriginalName();
        $pictureFile->move($params->get('pictures_directory'), $newFilename);

        // Set the new filename in the user entity
        $user->setProfilPicture($newFilename);

        // Save the user entity to the database
        $entityManager->persist($user);

        // Flush changes to the database
        $entityManager->flush();

        return $this->json([
            'message' => 'Image ajoutée avec succès'
        ]);
    }
}
