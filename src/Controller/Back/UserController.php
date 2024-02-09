<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class userController extends AbstractController
{
    /**
     * Shows all users in the backoffice
     * Don't forget that the route above ('/back/user') will be the start of all the routes created below
     * @return Response
     */
    #[Route('/', name: 'list_user')]
    public function browse(UserRepository $UserRepository): Response
    {
        // 1st step is getting all the users from the repository
        $users = $UserRepository->findAll();
       
        return $this->render('back/user/browse.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     *  Shows a user by ID in the backoffice
     *  Don't forget that the route above ('/back/user') will be the start of all the routes created below
     *
     * @return Response
     */
    #[Route('/show/{id}', name: 'show_user')]
    public function show(UserRepository $UserRepository, $user,  $id): Response
    {
        // Get the user by his ID
        $user = $UserRepository->find($id);
        
        // Return all the user in the view
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Create a user with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/create', name: 'create_user')]
    public function create(Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Create a instance for the entity user
        
        $user = new user();
        // Create a form

        $form = $this->createForm(UserType::class, $user); 

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        //checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the user has been created.
            $this->addFlash(
                'succès',
                'L utilisateur '.$user->getEmail().'a bien été créée !'
            );
            return $this->redirectToRoute('browse_user');
          }

        // Return the users in the view
        return $this->render('back/user/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a user via its ID in a form in the back office
     * @return Response
     */
    #[Route('/edit/{id}', name: 'edit_user')]
    public function edit(user $user, Request $request, EntityManagerInterface  $entityManager): Response
    {
         // Here , we want edit a user so no need to create anything.
     /*    The user exists already */
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(UserType::class, $user);
        // Here I build a form which manipulates an object $user which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
           // Here, no need to persist because it already exists so no need to recreate it 
        
            $entityManager->flush(); 

          /*   We will display a 'flash message' which will allow us to display whether or not the user has been created. */
            $this->addFlash(
                'succès',
                'L utilisateur '.$user->getEmail().' a bien été modifié !'
            );
            return $this->redirectToRoute('browse_user');
        }
        // Je passe tous les users à ma vue
        return $this->render('back/user/edit.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    /**
     *  Modify a user via its ID in a form in the back office
     * @return Response
     */
    #[Route('/remove/{id}', name: 'remove_user')]
    public function remove(user $user, UserRepository $UserRepository, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here , we want delete a user so no need to create anything.
     /*    The user exists already */

        // Delete the user
        $entityManager->remove($user);
        $entityManager->flush();
        
        // Return user to the home page
        return $this->redirectToRoute('browse_user');
    }
}
