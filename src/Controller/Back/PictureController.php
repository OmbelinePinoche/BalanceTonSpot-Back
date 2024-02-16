<?php

namespace App\Controller\Back;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PictureController extends AbstractController
{
    #[Route('/pictures', name: 'list_pictures')]
    public function list(PictureRepository $pictureRepository): Response
    {
        // 1st step is getting all the pictures from the repository
        $pictures = $pictureRepository->findAll();

        return $this->render('back/picture/browse.html.twig', [
            'pictures' => $pictures,
        ]);
    }

    #[Route('/spot/{slug}/pictures', name: 'picture_by_spot')]
    public function listBySpot(SpotRepository $spotRepository, $slug): Response
    {
        // Find the spot with the slug
        $spot = $spotRepository->find(['slug' => $slug]);

        // Check if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Spot non trouvé'], 404);
        }

        // Get the pictures associated to the spot
        $pictures = $spot->getPictures();

        // Check if there are pictures for the requested picture
        if (!$pictures) {
            return $this->json(['message' => 'Aucune image pour le spot sélectionné'], 404);
        }

        // Return the pictures associated to the spot
        return $this->render('back/picture/pictureBySpot.html.twig');
    }

    /**
     * Create a picture with a form in the backoffice
     * 
     * @return Response
     */
    #[Route('/admin/picture/new', name: 'add_picture')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create an instance for the entity Picture
        $picture = new Picture();
        // Create a form
        $form = $this->createForm(PictureType::class, $picture);

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);

        // Checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Validate and set necessary values before persisting
            $picture->setName($form->get('name')->getData());
            // Ensure that the 'path' property is a Symfony\Component\HttpFoundation\File\File instance
            $picture->setPath(new File($form->get('path')->getData()));

            $entityManager->persist($picture);
            $entityManager->flush();

            // We will display a flash message which will allow us to display whether or not the picture has been created.
            $this->addFlash(
                'succès',
                "L'image" . $picture->getName() . "a bien été ajoutée !"
            );

            // Return the pictures in the view
            return $this->redirectToRoute('list_pictures');
        }

        return $this->render('back/picture/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modify a picture via its ID in a form in the back office
     * @return Response
     */
    #[Route('/admin/picture/edit/{id}', name: 'edit_picture')]
    public function edit(Picture $picture, Request $request, EntityManagerInterface $entityManager): Response
    {
        // I build my form which revolves around my object
        // 1st param = the form class, 2eme param = the object we want to manipulate
        $form = $this->createForm(PictureType::class, $picture);
        // Here I build a form which manipulates an object $picture which already exists, therefore which already has values therefore in the form which will be displayed

        // I pass the information from my request to my form to find out if the form has been submitted
        $form->handleRequest($request);
        // checks if the form has been submitted and if it is valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Ensure that the 'path' property is a Symfony\Component\HttpFoundation\File\File instance
            $picture->setPath(new File($form->get('path')->getData()));
            // Here, no need to persist because it already exists so no need to recreate it 
            $entityManager->flush();

            // We will display a 'flash message' which will allow us to display whether or not the picture has been created
            $this->addFlash(
                'succès',
                "L'image" . $picture->getName() . " a bien été modifiée !"
            );
            return $this->redirectToRoute('list_pictures');
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
    #[Route('/admin/picture/remove/{id}', name: 'remove_picture')]
    public function remove(Picture $picture, EntityManagerInterface $entityManager): Response
    {
        // Here we want delete a picture so no need to create anything

        // Delete the picture
        $entityManager->remove($picture);
        $entityManager->flush();

        // Return user to the home page
        return $this->redirectToRoute('list_pictures');
    }
}
