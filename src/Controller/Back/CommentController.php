<?php

namespace App\Controller\Back;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comments')]
class CommentController extends AbstractController
{
    /**
     * Shows all comments in the backoffice
     * Don't forget that the route above ('/back/comment') will be the start of all the routes created below
     * @return Response
     */
    #[Route('/', name: 'list_comment')]
    public function browse(CommentRepository $CommentRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // 1st step is getting all the comments from the repository
        $comments = $CommentRepository->findAll();

        $pagination = $paginator->paginate(
            $comments,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('back/comment/browse.html.twig', [
            'comments' => $comments,
            'pagination' => $pagination
        ]);
    }

    /**
     *  Shows a comment by ID in the backoffice
     *  Don't forget that the route above ('/back/comment') will be the start of all the routes created below
     *
     * @return Response
     */
    #[Route('/show/{id}', name: 'show_comment')]
    public function show(CommentRepository $CommentRepository, $id): Response
    {
        // Gets the comment by his ID
        $comment = $CommentRepository->find($id);

        // Condition if the given comment id doesn't exist
        if (!$comment) {
            throw $this->createNotFoundException('Aucun commentaire ne répond à cet ID!');
        }

        // Returns all the comment in the view
        return $this->render('back/comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * Create a comment with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/new', name: 'add_comment')]
    public function create(Request $request, EntityManagerInterface  $entityManager): Response
    {
        // We want to fetch the currently authenticated user
        $user = $this->getUser();

        // We create an instance for the entity comment
        $comment = new Comment();

        // We set the user for the comment
        $comment->setUser($user);

        // Creates a form
        $form = $this->createForm(commentType::class, $comment, ['user' => $comment->getUser(),]);

        // We pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        //checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the comment has been created.
            $this->addFlash(
                'addcomment',
                'Le commentaire ' . $comment->getContent() . 'a bien été créé !'
            );
            return $this->redirectToRoute('list_comment');
        }

        // Returns the comments in the view
        return $this->render('back/comment/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a comment via its ID in a form in the back office
     * @return Response
     */
    #[Route('/edit/{id}', name: 'edit_comment')]
    public function edit(comment $comment, Request $request, EntityManagerInterface  $entityManager): Response
    {
        /*   The comment exists already */
        // Fetch the currently authenticated user
        $user = $this->getUser();

        // Check if the user is authenticated
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour modifier votre profil.');
        }
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(commentType::class, $comment);
        // Here I build a form which manipulates an object $comment which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Here, no need to persist because it already exists so no need to recreate it 

            $entityManager->flush();

            /*   We will display a 'flash message' which will allow us to display whether or not the comment has been updated. */
            $this->addFlash(
                'updatecomment',
                'Le commentaire ' . $comment->getContent() . ' a bien été modifié !'
            );

            // I return all the comments in the view
            return $this->redirectToRoute('list_comment');
        }

        return $this->render('back/comment/edit.html.twig', [
            'form' => $form,
            'comment' => $comment
        ]);
    }

    /**
     *  Modify a comment via its ID in a form in the back office
     * @return Response
     */
    #[Route('/remove/{id}', name: 'remove_comment')]
    public function remove(comment $comment, EntityManagerInterface  $entityManager): Response
    {
        // Here , we want delete a comment so no need to create anything.

        // Delete the comment
        $entityManager->remove($comment);
        $entityManager->flush();

        /*   We will display a 'flash message' which will allow us to display whether or not the comment has been deleted. */
        $this->addFlash(
            'deletecomment',
            'Le commentaire ' . $comment->getContent() . ' a bien été modifié !'
        );

        // Return user to the home page
        return $this->redirectToRoute('list_comment');
    }


    #[Route('/sort/{sortBy}', name: 'sort_comment')]
    public function triComment(CommentRepository $commentRepository, string $sortBy, Request $request, PaginatorInterface $paginator): Response
    {
        // Define default sorting method if an invalid one is provided
        $validSortOptions = ['pseudo', 'spot', 'date'];
        $sortBy = in_array($sortBy, $validSortOptions) ? $sortBy : 'pseudo';

        // Switch based on sorting method provided
        switch ($sortBy) {
                // If sorting by name
            case 'user':
                //Retrieve Comments sorted by User
                $comments = $commentRepository->findAllOrderedByUser();
                break;
                // If sorting by spot
            case 'spot':
                //Retrieve Comments sorted by Spot
                $comments = $commentRepository->findAllOrderedBySpot();
                break;
                // If sorting by date
            case 'date':
                //Retrieve Comments sorted by Date
                $comments = $commentRepository->findAllOrderedByDate();
                break;
                // If invalid sorting option provided, default to sorting by User
            default:
                $comments = $commentRepository->findAllOrderedByUser();
        }

        $pagination = $paginator->paginate(
            $comments,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        // Render the browse.html.twig template with sorted comments and sorting method
        return $this->render('back/comment/browse.html.twig', [
            'comments' => $comments,
            'sortBy' => $sortBy,
            'pagination' => $pagination
        ]);
    }
}
