<?php

namespace App\EventListener;

use App\Entity\Comment;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::postPersist, method: ['postPersist', 'postUpdate', 'postRemove'], entity: Comment::class)]
final class GlobalRatingListener
{
    public function postPersist(Comment $comment, PostPersistEventArgs $event)
    {
        $this->updateSpotRating($comment, $event);
    }

    public function postUpdate(Comment $comment, LifecycleEventArgs $event)
    {
        $this->updateSpotRating($comment, $event);
    }

    public function postRemove(Comment $comment, LifecycleEventArgs $event)
    {
        $this->updateSpotRating($comment, $event);
    }

    private function updateSpotRating(Comment $comment, LifecycleEventArgs $event)
    {
        $spot = $comment->getSpot();

        $allNotes = 0;

        // Loop through all comments of the spot
        foreach ($spot->getComments() as $comment) {
            // Accumulate the ratings
            $allNotes = $allNotes + $comment->getRating();
        }

        // Calculate the average rating by dividing the total sum by the number of comments
        $average = $allNotes / count($spot->getComments());

        $spot->setRating($average);

        $entityManager = $event->getObjectManager();
        $entityManager->flush();
    }
}
