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
        #[Route('/favoris/list', name: 'favorites_list')]
        public function list(Request $request): Response
        {
            // Retrieve the session from the request
            $session = $request->getSession();
            
            // Retrieve the value associated with the 'favoris' key in the session
            $favoris = $session->get('favoris', []);
    
            // Pass the list of favorites to the view
            return $this->render('back/favoris/list.html.twig', [
                'favoris' => $favoris
            ]);
        }
    

    /**
     * Add a spot in the favoris list
     *
     * @return void
     */
    #[Route('/favoris/add/{id}', name: 'favorites_add')]
    public function add(Request $request, Spot $Spot, FavorisManager $favorisManager): Response
    {
        // Recover the spot id
        $id = $Spot->getId();

        // Check if the spot exists
        if (!$Spot) {
            throw $this->createNotFoundException('Spot non trouvé');
        }

        // Add the spot to favorites using FavorisManager
        $favorisManager->add($id, $Spot);

        // Add a flash message indicating the spot has been added to favorites
        $this->addFlash(
            'success',
            'Le spot ' . $Spot->getName() . ' a bien été ajouté dans les favoris !'
        );

        // Redirect back to the favorites list page
        return $this->redirectToRoute('favorites_list');
    }

    /**
     * Function that empties the favorites list
     *
     * @return void
     */
    #[Route('/favoris/clear', name: 'favorites_clear')]
    public function clear(Request $request)
    {
        //  I recover the data from the session thanks to $request->getSession()
        $session = $request->getSession();
        // I empty the element whose key name is 'favorites' (to empty the favorites)
        $session->remove('favoris');
        // I redirect to the list of spots (empty now)
        return $this->redirectToRoute('favorites_list');
    }

     /**
     * Function that removes a spot from the favorites list
     *
     * @return void
     */
    #[Route('/favoris/remove/{id}', name: 'favorites_remove')]
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
        return $this->redirectToRoute('favorites_list');
    }
}
