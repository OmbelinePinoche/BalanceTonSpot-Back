<?php

namespace App\Controller\Back;

use App\Entity\Spot;
use App\Service\FavorisManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 */
class FavoritesController extends AbstractController
{
    /**
     * Shows favorite spots of the session
     *
     * 
     * @return Response
     */
    
    #[Route('/favorites/list', name: 'list_favorites')]
    public function list(Request $request): Response
    {
        // Retrieve the session from the request
        $session = $request->getSession();

        // Retrieve the value associated with the 'favorites' key in the session
        $favorites = $session->get('favoris');

        // Pass the list of favorites to the view
        return $this->render('back/favorites/browse.html.twig', [
            'favorites' => $favorites
        ]);
    }

    /**
     * Add a spot in the favorites list
     *
     * @return void
     */
    #[Route('/favorite/add/{id}', name: 'add_favorite')]
    public function add(Spot $spot, Request $request): Response
    {
        // Recover the spot id
        $id = $spot->getId();

        // Check if the spot exists
        if (!$spot) {
            throw $this->createNotFoundException('Spot non trouvé');
        }

        // Get the session data
        $session = $request->getSession();

        // Get the session favorites in a array
        $favorites = $session->get('favoris', []);

        // We add the object $spot to this array
        // This way we won't have twice the same spot in the list
        $favorites[$id] = $spot;

        // We update the favorites in the session
        $session->set('favoris', $favorites);

        // Add a flash message indicating the spot has been added to favorites
        $this->addFlash(
            'success',
            'Le spot ' . $spot->getName() . ' a bien été ajouté dans les favoris !'
        );

        // Redirect back to the favorites list page
        return $this->redirectToRoute('list_favorites');
    }

    /**
     * Function that empties the favorites list
     *
     * @return void
     */
    #[Route('/favorites/clear', name: 'clear_favorites')]
    public function clear(Request $request)
    {
        //  I recover the data from the session thanks to $request->getSession()
        $session = $request->getSession();
        // I empty the element whose key name is 'favorites' (to empty the favorites)
        $session->remove('favoris');
        // I redirect to the list of spots (empty now)
        return $this->redirectToRoute('list_favorites');
    }

    /**
     * Function that removes a spot from the favorites list
     *
     * @return void
     */
    #[Route('/favorite/remove/{id}', name: 'remove_favorites')]
    public function remove(Request $request, $id)
    {
        // I recover the data from the session thanks to $request->getSession()
        $session = $request->getSession();
        // I recover favorites from the session, in table form
        $favoris = $session->get('favoris', []);
        // I remove the element whose index is $
        // unset : https://stackoverflow.com/questions/369602/deleting-an-element-from-an-array-in-php
        unset($favoris[$id]);
        // I update my favorites without the Spot (which was deleted)
        $session->set('favoris', $favoris);
        // I redirect to the list of spots (empty now)
        return $this->redirectToRoute('list_favorites');
    }
}
