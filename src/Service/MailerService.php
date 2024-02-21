<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService

{
    public function __construct(
        #[Autowire('%admin_email%')] private string $adminEmail,
        private readonly MailerInterface $mailer,
    ) {
    }

    public function sendWelcomeEmail(): void
    {

        $email = (new NotificationEmail())
            ->subject('Welcome')
            ->from($this->adminEmail)
            ->to($this->adminEmail)
            ->htmlTemplate(template: 'back/email/browse.html.twig')
            ->context([
                'username' => 'Gatien'



            ]);

        $this->mailer->send($email);
    }


    public function sendEmail(User $user): JsonResponse
    {
        try {
            $email = (new Email())
                ->subject('Welcome')
                ->from($user->getEmail())
                ->to($this->adminEmail)
                ->text('Très content de votre site');

            $this->mailer->send($email);

            return new JsonResponse(['message' => 'Email envoyé avec succès'], JsonResponse::HTTP_OK);
        } catch (TransportExceptionInterface $e) {
            return new JsonResponse(['message' => 'Echec de l/envoi de mail', 'error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
