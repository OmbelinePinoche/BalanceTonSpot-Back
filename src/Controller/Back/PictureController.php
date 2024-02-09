<?php

namespace App\Controller\Back;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\pictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PictureController extends AbstractController
{
    /**
     * Shows all pictures in the backoffice
     * Don't forget that the route above ('/back/picture') will be the start of all the routes created below
     * @return Response
     */
    #[Route('/', name: 'list_picture')]
    public function browse(PictureRepository $pictureRepository): Response
    {
        // 1st step is getting all the pictures from the repository
        $pictures = $pictureRepository->findAll();
       
        return $this->render('back/picture/browse.html.twig', [
            'pictures' => $pictures,
        ]);
    }

    /**
     *  Shows a picture by ID in the backoffice
     *  Don't forget that the route above ('/back/picture') will be the start of all the routes created below
     *
     * @return Response
     */
    #[Route('/show/{id}', name: 'show_picture')]
    public function show(PictureRepository $pictureRepository, $picture,  $id): Response
    {
        // Get the picture by his ID
        $picture = $pictureRepository->find($id);
        
        // Return all the picture in the view
        return $this->render('back/picture/show.html.twig', [
            'picture' => $picture,
        ]);
    }

    /**
     * Create a picture with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/create', name: 'create_picture')]
    public function create(Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Create a instance for the entity picture
        
        $picture = new picture();
        // Create a form

        $form = $this->createForm(pictureType::class, $picture); 

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        //checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($picture);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the picture has been created.
            $this->addFlash(
                'succès',
                'Le picture '.$picture->getName().'a bien été créée !'
            );
            return $this->redirectToRoute('browse_picture');
          }

        // Return the pictures in the view
        return $this->render('back/picture/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a picture via its ID in a form in the back office
     * @return Response
     */
    #[Route('/edit/{id}', name: 'edit_picture')]
    public function edit(picture $picture, Request $request, EntityManagerInterface  $entityManager): Response
    {
         // Here , we want edit a picture so no need to create anything.
     /*    The picture exists already */
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(pictureType::class, $picture);
        // Here I build a form which manipulates an object $picture which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
           // Here, no need to persist because it already exists so no need to recreate it 
        
            $entityManager->flush(); 

          /*   We will display a 'flash message' which will allow us to display whether or not the picture has been created. */
            $this->addFlash(
                'succès',
                'Le picture '.$picture->getName().' a bien été modifié !'
            );
            return $this->redirectToRoute('browse_picture');
        }
        // Je passe tous les pictures à ma vue
        return $this->render('back/picture/edit.html.twig', [
            'form' => $form,
            'picture' => $picture
        ]);
    }

    /**
     *  Modify a picture via its ID in a form in the back office
     * @return Response
     */
    #[Route('/remove/{id}', name: 'remove_picture')]
    public function remove(picture $picture, pictureRepository $pictureRepository, Request $request, EntityManagerInterface  $entityManager): Response
    {
        // Here , we want delete a picture so no need to create anything.
     /*    The picture exists already */

        // Delete the picture
        $entityManager->remove($picture);
        $entityManager->flush();
        
        // Return user to the home page
        return $this->redirectToRoute('browse_picture');
    }
}
