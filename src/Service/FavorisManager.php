<?php

namespace App\Service;

use App\Entity\Spot;
use Symfony\Component\HttpFoundation\RequestStack;

class FavorisManager
{
    private $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    /**
     *
     * Function that adds a spot into the session
     *
     * @return string
     */
    public function add(int $id, Spot $spot)
    {
        // I recover the session
        $session = $this->requestStack->getSession();
        // I retrieve the session favorites, in table form
        $favorites = $session->get('favorites', []);
        // Add the spot with the id so as not to have a duplicate
        $favorites[$id] = $spot;
        // Update 'favorites'
        $session->set('favorites', $favorites);
    }
}