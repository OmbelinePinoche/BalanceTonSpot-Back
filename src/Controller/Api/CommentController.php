<?php

namespace App\Controller\Api;


use App\Entity\Comment;
use App\Entity\Spot;
use App\Repository\CommentRepository;
use App\Form\FileTransformer;
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

    #[Route('/api/comment/{slug}', name: 'api_show_comment', methods: ['GET'])]
    public function show(CommentRepository $commentRepository, $slug): Response
    {
        // 1st step is getting all the comments from the repository
        $comment = $commentRepository->findOneBy(['slug' => $slug]);

        if (!$comment) {
            return $this->json(['message' => 'Commentaire non trouvé'], 404);
        }
        // We want to return the comments to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json($comment,200, [], ['groups' => 'api_show_comment']
        );
    }

    #[Route('/api/comment/{slug}/spots', name: 'api_show_by_comment', methods: ['GET'])]
    public function listBycomment($slug, CommentRepository $commentRepository): Response
    {
        // Find the comment with the slug
        $comment = $commentRepository->findOneBy(['slug' => $slug]);

        // Check if the comment exists
        if (!$comment) {
            return $this->json(['message' => 'Commentaire non trouvé'], 404);
        }

        // Get the spots associated with the comment
        $spots = $comment->getSpotId();

        // Check if there are spots for the requested comment
        if (!$spots) {
            return $this->json(['message' => 'Aucun commentaire trouvé dans le spot sélectionné'], 404);
        }

        // Return the spots associated with the comment
        return $this->json($spots, 200, [], ['groups' => 'api_show_by_comment']);
    }

}
