<?php

namespace App\EventListener;

use App\Entity\Comment;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;

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
        // Calculate the average rating by dividing the total sum by the number of comments
        $average = $allNotes / count($spot->getComments());

        // we set the calculated average rating to the spot
        $spot->setRating($average);

        // We get the entityManager from the Doctrine Object Manager
        $entityManager = $event->getObjectManager();

        // We persist the changes to the database
        $entityManager->flush();
    }

    /**
     * Updates the spot rating based on its comments.
     */
    private function updateSpotRating(Comment $comment, LifecycleEventArgs $event)
    {
        // We get the spot associated with the comment
        $spot = $comment->getSpot();

        // Initialize the total sum of ratings
        $allNotes = 0;

        // Loop through all comments of the spot
        foreach ($spot->getComments() as $comment) {
            // Accumulate the ratings
       $allNotes = $allNotes + $comment->getRating();
        }

        // Calculate the average rating by dividing the total sum by the number of comments
        $average = $allNotes / count($spot->getComments());

        // Update the spot's average rating
        $spot->setRating($average);

        $entityManager = $event->getObjectManager();

        // Persist the changes to the database
        $entityManager->flush();
    }

    /**
     * Handles postRemove event for Comment entity.
     */
    public function postRemove(Comment $comment, LifecycleEventArgs $event)
    {
        $this->updateSpotRating($comment, $event);
    }
}
