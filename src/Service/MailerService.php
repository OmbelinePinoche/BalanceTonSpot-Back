<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;

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
            ->htmlTemplate (template:'back/email/browse.html.twig')
            ->context([
                'username' => 'Gatien'



            ]);

        $this->mailer->send($email);
    }
}
