<?php

namespace App\Controller\Api;


use App\Entity\Spot;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\FileTransformer;
use App\Repository\SpotRepository;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    
    #[Route('/api/comments', name: 'api_list_comment', methods: ['GET'])]
    public function list(CommentRepository $commentRepository): Response
    {
        // 1st step is getting all the comments from the repository
        $comments = $commentRepository->findAll();
        // We want to return the comments to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $comments,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_list_comment']
        );
    }

    #[Route('/api/comment/{id}', name: 'api_show_comment', methods: ['GET'])]
    public function show(CommentRepository $commentRepository, $id): Response
    {
        // 1st step is getting all the comments from the repository
        $comment = $commentRepository->find($id);

        if (!$comment) {
            return $this->json(['message' => 'Commentaire non trouvé'], 404);
        }
        // We want to return the comments to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            $comment,
            200,
            [],
            ['groups' => 'api_show_comment']
        );
    }

    #[Route('/api/spot/{slug}/comments', name: 'api_comment_by_spot', methods: ['GET'])]
    public function listByComment(SpotRepository $spotRepository, CommentRepository $commentRepository, $slug, Comment $content = null): Response
    {
        // Get the comments from the repository searching with the "content" param
        $spot = $spotRepository->findOneBy(['slug' => $slug]);
        
        // Check if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Aucun spot trouvé!'], 404);
        }

        // Call the function to get the comments from the spot entity
        $comments = $spot->getComments();

        // Check if any comment exists
        if (!$comments) {
            return $this->json(['message' => 'Aucun commentaire n\a été ajouté à ce spot'], 404);
        }

        // Return all the comments according to the comment
        return $this->json($comments, 200, [], ['groups' => 'api_comment_by_spot']);
    }

    #[Route('/api/comments', name: 'api_add_comment', methods: ['POST'])]
    public function addComment(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Retrieve the data send in the POST request
        $data = json_decode($request->getContent(), true);

        if (!isset($data['content'], $data['username'], $data['spot'])) {
            return $this->json(['message' => 'Données manquantes'], 400);
        }

        // Create a new Comment instance
        $comment = new Comment();

        // Set the properties from the given data
        $comment->setContent($data['content']);
        $comment->setUsername($data['username']);
        $spot= $entityManager->getRepository(Spot::class)->find($data['spot']);
        $comment->setSpot($spot);
    
        

      // We need to persist the COMMENT entity to the database to save the data
        $entityManager->persist($comment);
        $entityManager->flush();

        // Return the comment create with the status http 201
        return $this->json(['message' => 'Commentaire ajouté avec succès'], 201);
    } 


    #[Route('/api/secure/comment/{id}', name: 'api_update_comment', methods: ['PUT'])]
    public function update(CommentRepository $commentRepository, Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        // Find the comment by ID
        $comment = $commentRepository->find($id);
    
        // Check if the comment exists
        if (!$comment) {
            return $this->json(['message' => 'No comment found for the given ID'], 404);
        }
    
        // Retrieve the data sent in the PUT request
        $data = json_decode($request->getContent(), true);
    
        // Update the properties of the comment if they are present in the request data
        if (isset($data['content'])) {
            $comment->setContent($data['content']);
        }
        if (isset($data['username'])) {
            $comment->setUsername($data['username']);
        }
        if (isset($data['spot'])) {
        }
        if (isset($data['date'])) {
        
        }
        if (isset($data['rating'])) {
            $comment->setRating($data['rating']);
        }
    
        // Persist the update
        $entityManager->flush();
    
        // Return a success response
        return $this->json(['message' => 'Commentaire mis à jour avec succès'], 200);
    }

    #[Route('/api/secure/comment/{id}', name: 'api_comment_delete', methods: ['DELETE'])]
    public function removeComment(comment $comment = null, EntityManagerInterface $entityManager): Response
    {
        // Check if the comment exists
        if (!$comment) {

            return $this->json(['message' => 'Aucun commentaire trouvé'], 404);
        }
        // Delete the data send in the request 
        $entityManager->remove($comment);
        $entityManager->flush();

        // Return the success message
        return $this->json(['message' => 'Commentaire supprimé avec succès!'], 200);
    }
}

