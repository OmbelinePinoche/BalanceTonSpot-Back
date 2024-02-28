<?php
namespace App\Controller\Back;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/email')]
    public function index(MailerService $mailerService): Response
    {

        $mailerService->sendWelcomeEmail();

        return $this->render('back/email/browse.html.twig', [
            'controller_name' => 'MailerController',
 
                  ]);
}
} 