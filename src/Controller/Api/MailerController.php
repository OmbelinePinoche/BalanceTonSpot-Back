<?php

namespace App\Controller\Api;

use App\Service\MailerService;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/api/emails', methods: ['GET'])]
    public function getEmails(): Response
    {
        // Retrieves all users from the repository
        $users = $this->userRepository->findAll();

        // Extracts email addresses of the users
        $emails = array_map(function ($user) {
            return $user->getEmail();
        }, $users);

        // Returns email addresses as a JSON response
        return $this->json($emails);
    }


    #[Route('/api/emails', methods: ['POST'])]
    public function sendEmail(Request $request, MailerService $mailerService): JsonResponse
    {
        // Decodes the request content to retrieve data
        $data = json_decode($request->getContent(), true);
        // Extracts the user email and message from the data
        $userEmail = $data['user_email'] ?? null;
        $subject = $data['subject'] ?? null;
        $content = $data['content'] ?? null;

        // Checks if the user email and message are provided
        if (!$userEmail || !$content || !$subject) {
            // Returns a JSON response with a message indicating that email and message are required
            return new JsonResponse(['message' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        // Finds the user by email in the repository
        $user = $this->userRepository->findOneBy(['email' => $userEmail]);
    
        // Checks if the user is found
        if (!$user) {
            // Returns a JSON response with a message indicating user not found
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }
    
        // Calls the sendEmail() method of the MailerService and pass the user object and message
        $success = $mailerService->sendEmail($user,$subject,$content);
    
        // Checks if the email was sent successfully
        if ($success) {
            // If successful, return a JSON response with a success message
            return new JsonResponse(['message' => 'L\'email a été envoyé avec succès'], Response::HTTP_OK);
        } else {
            // If failed, return a JSON response with an error message
            return new JsonResponse(['message' => 'Echec de l\'envoi de mail'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}