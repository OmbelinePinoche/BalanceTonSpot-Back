<?php

namespace App\Controller\Back;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    public function browse(CommentRepository $CommentRepository): Response
    {
        // 1st step is getting all the comments from the repository
        $comments = $CommentRepository->findAll();

        return $this->render('back/comment/browse.html.twig', [
            'comments' => $comments
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
        // Get the comment by his ID
        $comment = $CommentRepository->find($id);

        // Condition if the given comment id doesn't exist
        if (!$comment) {
            throw $this->createNotFoundException('Aucun commentaire ne répond à cet ID!');
        }

        // Return all the comment in the view
        return $this->render('back/comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * Create a comment with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/user/new', name: 'add_comment')]
    public function create(Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Create an instance for the entity comment
        $comment = new Comment();
        // Create a form
        $form = $this->createForm(commentType::class, $comment);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        //checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the comment has been created.
            $this->addFlash(
                'succès',
                'Le commentaire ' . $comment->getContent() . 'a bien été créé !'
            );
            return $this->redirectToRoute('list_comment');
        }

        // Return the comments in the view
        return $this->render('back/comment/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a comment via its ID in a form in the back office
     * @return Response
     */
    #[Route('/user/edit/{id}', name: 'edit_comment')]
    public function edit(comment $comment, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here we want to edit a comment so no need to create anything.
        /*    The comment exists already */
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

            /*   We will display a 'flash message' which will allow us to display whether or not the comment has been created. */
            $this->addFlash(
                'succès',
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
    #[Route('/user/remove/{id}', name: 'remove_comment')]
    public function remove(comment $comment, CommentRepository $CommentRepository, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here , we want delete a comment so no need to create anything.

        // Delete the comment
        $entityManager->remove($comment);
        $entityManager->flush();

        // Return user to the home page
        return $this->redirectToRoute('list_comment');
    }


    #[Route('/tri/{sortBy}', name: 'tri_comment')]
    public function triComment(CommentRepository $commentRepository, string $sortBy): Response
    {
        // Define default sorting method if an invalid one is provided
        $validSortOptions = ['pseudo', 'spot', 'date']; // Define valid sorting options
        $sortBy = in_array($sortBy, $validSortOptions) ? $sortBy : 'pseudo';

        // Fetch comments based on the chosen sorting method
        switch ($sortBy) {
            case 'username':
                $comments = $commentRepository->findAllOrderedByUsername();
                break;
            case 'spot':
                $comments = $commentRepository->findAllOrderedBySpot();
                break;
            case 'date':
                $comments = $commentRepository->findAllOrderedByDate();
                break;
            default:
                $comments = $commentRepository->findAllOrderedByUsername();
        }

        return $this->render('back/comment/browse.html.twig', [
            'comments' => $comments,
            'sortBy' => $sortBy, // Pass the current sorting method to the template
        ]);
    }
}
