<?php

namespace App\Controller\Back;

use App\Entity\Spot;
use App\Service\FavorisManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Gère les favoris
 */
class FavoritesController extends AbstractController
{
    /**
     * Affiche les spots favoris de la session
     *
     * $request => sert à avoir des informations sur la requête
     * @return Response
     */
    #[Route('/favoris/list', name: 'favoris_list')]
    public function list(Request $request): Response
    {
        // Je recupere les données de la session grace a $request->getSession()
        $session = $request->getSession();
        // Je recupere la valeur associés à la clé 'favoris' dans ma session
        // $session->set('favoris', ['toto', 'tata']);
        $favoris = $session->get('favoris');

        // dd($favoris);
        return $this->render('back/favoris/list.html.twig', [
            // Je passe la liste des favoris à ma vue
            'favoris' => $favoris
        ]);
    }

    /**
     * Ajoute un film dans la liste des favoris
     *
     * @return void
     */
    #[Route('/favoris/add/{id}', name: 'favoris_add')]
    public function add(Request $request, Spot $Spot, FavorisManager $favorisManager)
    {
        // Je recupere l'id du $Spot
        $id = $Spot->getId();

        // $session->remove('favoris');
        $favorisManager->add($id, $Spot);
        // On redirige vers la liste des spots
        // J'envoie un message flash qui dit que le film a bien été ajouté aux favoris
        $this->addFlash(
            'Trop classe',
            'Le film '.$Spot->getName().' a bien été ajouté dans les favoris !'
        );
        return $this->redirectToRoute('favoris_list');
    }

    /**
     * Fonction qui vide la liste des favoris
     *
     * @return void
     */
    #[Route('/favoris/clear', name: 'favoris_clear')]
    public function clear(Request $request)
    {
        // Je recupere les données de la session grace a $request->getSession()
        $session = $request->getSession();
        // Je vide l'element qui a pour nom de clé 'favoris' (pour vider les favoris)
        $session->remove('favoris');
        // Je redirige sur la liste des spots (vide maintenant)
        return $this->redirectToRoute('favoris_list');
    }

     /**
     * Fonction qui supprime un film de la liste des favoris
     *
     * @return void
     */
    #[Route('/favoris/remove/{id}', name: 'favoris_remove')]
    public function remove(Request $request, $id)
    {
        // Je recupere les données de la session grace a $request->getSession()
        $session = $request->getSession();
        // Je recupere favoris de la session, sous forme de tableau 
        $favoris = $session->get('favoris', []);
        // J'enleve l'element qui a pour index $id
        // unset : https://stackoverflow.com/questions/369602/deleting-an-element-from-an-array-in-php
        unset($favoris[$id]);
        // Je mets a jour favoris avec le Spot en moins (qu'on a supprimé)
        $session->set('favoris', $favoris);
        // Je redirige sur la liste des spots (vide maintenant)
        return $this->redirectToRoute('favoris_list');
    }
}
