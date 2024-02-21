<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * Method that identifies the user
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        // Create an instance for the entity user
        $user = new User();
        // Create a form
        $form = $this->createForm(RegistrationFormType::class, $user);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password before register in the BDD
            $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
            // Persist the user to the BDD
            $entityManager->persist($user);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the user has been created.
            $this->addFlash(
                'success',
                'L\'utilisateur ' . $user->getEmail() . ' a bien été créé !'
            );

            // Return the users in the view
            return $this->redirectToRoute('list');
        }

        return $this->render('back/security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}