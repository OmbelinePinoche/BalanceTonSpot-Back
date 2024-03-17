<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Entity\Comment;
use App\Repository\SpotRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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

    #[Route('/api/spot/{slug}/comments', name: 'api_comment_by_spot', methods: ['GET'])]
    public function listBySpot(CommentRepository $commentRepository, SpotRepository $spotRepository, $slug): Response
    {
        // We need to search the spot in the repository thanks to the property "slug"
        $spot = $spotRepository->findOneBy(['slug' => $slug]);

        // Checks if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Aucun spot associé à ce nom'], 404);
        }

        // Calls the function to get the comments from the spot entity
        $comments = $spot->getComments();

        // Checks if any comment exists
        if (!$comments) {
            return $this->json(['message' => 'Aucun commentaire n\a été ajouté à ce spot'], 404);
        }

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
            ['groups' => 'api_comment_by_spot']
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

    #[Route('/api/spot/{slug}/comments', name: 'api_add_comment', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager, $slug, SpotRepository $spotRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->json(['message' => 'Utilisateur introuvable'], 404);
        }

        // Finds the spot by its slug
        $spot = $spotRepository->findOneBy(['slug' => $slug]);

        // Checks if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Aucun spot associé à ce nom'], 404);
        }

        $content = $request->getContent();
        $data = json_decode($content, true);

        // Checks if the content is present in the decoded data
        if (!isset($data['content'], $data['rating'])) {
            return $this->json(['message' => 'Un champ requis est manquant dans la requête JSON'], 400);
        }

        $comment = new Comment;
        // Set the comment properties
        $comment->setUser($user);
        $comment->setSpot($spot);
        $comment->setContent($data['content']);
        $comment->setRating($data['rating']);
        if (isset($data['date'])) {
            $comment->setDate(\DateTime::createFromFormat('d-m-Y', $data['date']));
        }

        // We need to persist the Comment entity to the database to save the data
        $entityManager->persist($comment);
        $entityManager->flush();

        // Returns the comment created with the HTTP status 201
        return $this->json(['message' => 'Commentaire ajouté avec succès!'], 201);
    }

    #[Route('/api/secure/comment/{id}', name: 'api_update_comment', methods: ['PUT'])]
    public function update(CommentRepository $commentRepository, Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        // Find the comment by ID
        $comment = $commentRepository->find($id);

        // Check if the comment exists
        if (!$comment) {
            return $this->json(['message' => 'Aucun commentaire associé à cet ID'], 404);
        }

        // Retrieve the data sent in the PUT request
        $data = json_decode($request->getContent(), true);

        // Update the properties of the comment if they are present in the requested data
        if (isset($data['content'])) {
            $comment->setContent($data['content']);
        }
        if (isset($data['user'])) {
            $comment->setUser($data['user']);
        }
        if (isset($data['spot'])) {
            $comment->setSpot($data['spot']);
        }
        if (isset($data['date'])) {
            $comment->setDate($data['date']);
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
    public function delete(Comment $comment = null, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

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
