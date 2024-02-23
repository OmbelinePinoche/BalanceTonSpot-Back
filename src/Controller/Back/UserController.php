<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/users')]
class UserController extends AbstractController
{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

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
     *  Shows a user by its slug in the backoffice
     *  Don't forget that the route above ('/back/user') will be the start of all the routes created below
     *
     * @return Response
     */
    #[Route('/show/{pseudo}', name: 'show_user')]
    public function show(UserRepository $userRepository,  $pseudo): Response
    {
        // Get the user by its pseudo
        $user = $userRepository->findOneBy(['pseudo' => $pseudo]);

        // Checks if the user exists
        if (!$user) {
            throw $this->createNotFoundException('Aucun utilisateur ne répond à ce nom!');
        }

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
    #[Route('/new', name: 'add_user')]
    public function create(Request $request, EntityManagerInterface  $entityManager, ParameterBagInterface $params): Response
    {
        // Create an instance for the entity user
        $user = new User();
        // Create a form
        $form = $this->createForm(UserType::class, $user);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile */
            $pictureFile = $form->get('profilPictureFile')->getData();
            if ($pictureFile) {

                $newFilename = uniqid() . '.' . $pictureFile->getClientOriginalName();

                // Move the file to the directory where pictures are stored
                $pictureFile->move($params->get('pictures_directory'), $newFilename);

                $user->setProfilPicture($newFilename);
            }

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
            return $this->redirectToRoute('list_user');
        }

        return $this->render('back/user/create.html.twig', [
            'form' => $form,
        ]);
    }
    /**
     * Modify a user via its pseudo in a form in the back office
     * @return Response
     */
    #[Route('/edit/{pseudo}', name: 'edit_user')]
    public function edit(Request $request, EntityManagerInterface  $entityManager, User $user, ParameterBagInterface $params): Response
    {
        // // Get the current user
        // $user = $this->getUser();

        // // Check if the user is authenticated
        // if (!$user) {
        //     throw $this->createAccessDeniedException('Vous devez être connecté pour modifier votre profil.');
        // }
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(UserType::class, $user);
        // Here I build a form which manipulates an object $user which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile */
            $pictureFile = $form->get('profilPictureFile')->getData();
            if ($pictureFile) {

                $newFilename = uniqid() . '.' . $pictureFile->getClientOriginalName();

                // Move the file to the directory where pictures are stored
                $pictureFile->move($params->get('pictures_directory'), $newFilename);

                $user->setProfilPicture($newFilename);
            }

            // Here, no need to persist because it already exists so no need to recreate it 
            // Hash the password before register in the BDD
            $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
            
            // Save the changes to the BDD
            $entityManager->flush();

            // We will display a 'flash message' which will allow us to display whether or not the user has been created
            $this->addFlash(
                'succès',
                'L utilisateur ' . $user->getPseudo() . ' a bien été modifié !'
            );
            return $this->redirectToRoute('list_user');
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
    public function remove(user $user, EntityManagerInterface  $entityManager): Response
    {
        // Here we want delete a user so no need to create anything.
        // The user exists already 

        // Delete the user
        $entityManager->remove($user);
        $entityManager->flush();

        // Return user to the home page
        return $this->redirectToRoute('list_user');
    }

    #[Route('/sort/{sortBy}', name: 'sort_user')]
    public function triUser(UserRepository $userRepository, string $sortBy): Response
    {

        // Define default sorting method if an invalid one is provided
        $validSortOptions = ['pseudo', 'email', 'role'];
        $sortBy = in_array($sortBy, $validSortOptions) ? $sortBy : 'pseudo';

        switch ($sortBy) {
                // If sorting by username
            case 'username':
                // Retrieve pictures sorted by Pseudo
                $users = $userRepository->findAllOrderedByPseudo();
                break;
                // If sorting by email
            case 'email':
                // Retrieve pictures sorted by Email
                $users = $userRepository->findAllOrderedByEmail();
                break;
                // If sorting by role
            case 'role':
                // Retrieve pictures sorted by Role
                $users = $userRepository->findAllOrderedByRole();
                break;
                // If invalid sorting option provided, default to sorting by Pseudo
            default:
                $users = $userRepository->findAllOrderedByPseudo();
        }
        // Render the browse.html.twig template with sorted users and sorting method
        return $this->render('back/user/browse.html.twig', [
            'users' => $users,
            'sortBy' => $sortBy,
        ]);
    }
}
