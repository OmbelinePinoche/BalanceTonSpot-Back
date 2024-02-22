<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\Mime\Address;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

class ResetPasswordController extends AbstractController
{
    private ResetPasswordHelperInterface $resetPasswordHelper;
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;
    private ?SessionInterface $session = null;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper, EntityManagerInterface $entityManager, MailerInterface $mailer, SessionInterface $session)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->session = $session;
    }


    //Routes API


    #[Route('/api/reset-password/request', name: 'api_reset_password_request', methods: ['POST'])]
    public function request(Request $request): JsonResponse
    {
        // Create a form instance for reset password request
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Process sending password reset email
            return $this->processSendingPasswordResetEmail($form->get('email')->getData());
        }

        // If form submission is invalid, return a JSON response with an error message
        return new JsonResponse(['message' => 'Requête invalide'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/api/reset-password/check-email', name: 'api_check_email', methods: ['GET'])]
    public function checkEmail(): JsonResponse
    {
        // Attempt to retrieve the reset token from the session
        $resetToken = $this->getTokenFromSession();

        // If no reset token found in session, generate a fake reset token
        if (null === $resetToken) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        // Return the reset token in a JSON response
        return new JsonResponse(['resetToken' => $resetToken]);
    }

    #[Route('/api/reset-password/reset/{token}', name: 'api_reset_password', methods: ['POST'])]
    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, string $token): JsonResponse
    {
        // Retrieve the user associated with the token
        $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);

        // If user not found, return a JSON response with an error message
        if (!$user) {
            return new JsonResponse(['message' => 'Token invalide ou expiré'], Response::HTTP_BAD_REQUEST);
        }

        // Create a form to enter the new password
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        // If form is not submitted or is invalid, return a JSON response with an error message
        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse(['message' => 'Données invalides'], Response::HTTP_BAD_REQUEST);
        }

        // Get the new password from the form
        $newPassword = $form->get('plainPassword')->getData();

        // Hash the new password
        $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);

        // Update the user's password
        $user->setPassword($hashedPassword);
        $this->entityManager->flush();

        // Remove the password reset request from the session
        $this->resetPasswordHelper->removeResetRequest($token);

        // Respond with a success message
        return new JsonResponse(['message' => 'Mot de passe changé avec succès'], Response::HTTP_OK);
    }


       // Private methods

    private function processSendingPasswordResetEmail(string $emailFormData): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            return new JsonResponse(['message' => 'Erreur lors de la génération de la réinitialisation du mot de passe'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $email = (new TemplatedEmail())
            ->from(new Address('Balancetonspot@outlook.com', 'BTS'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->context([
                'resetToken' => $resetToken,
            ]);

        $this->mailer->send($email);

        // Return the token in the JSON response
        return new JsonResponse(['message' => 'Demande de changement de mot de passe envoyé', 'resetToken' => $resetToken], Response::HTTP_OK);
    }

    private function getTokenFromSession(): ?string
    {
        // Get the password reset token from the session
        return $this->session->get('reset_password_token');
    }
}
