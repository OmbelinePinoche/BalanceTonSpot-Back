<?php

namespace App\EventListener;

use App\Entity\Comment;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Comment::class)]
final class GlobalRatingListener
{

    public function postPersist(Comment $comment, PostPersistEventArgs $event)
    {
        // We need to retrieve the spot from the variable comment
        $spot = $comment->getSpot();

        // We want to nitialize a variable to store the sum of all notes for the spot
        $allNotes = 0;

        // Loop on every spot comments
        foreach ($spot->getComments() as $comment) {
            // Add the rating of each comment to the total sum
            $allNotes = $allNotes + $comment->getRating();
        }

        if ($allNotes == 0) {
            $spot->setRating(0);
        } 
        else {
            $average = $allNotes / count($spot->getComments());
            $spot->setRating($average);
        }

        // We get the entityManager from the Doctrine Object Manager
        $entityManager = $event->getObjectManager();

        // We persist the changes to the database
        $entityManager->flush();
    }

}
