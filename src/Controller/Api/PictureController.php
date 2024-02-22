<?php

namespace App\Controller\Api;

use App\Repository\PictureRepository;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PictureController extends AbstractController
{
    #[Route('/api/pictures', name: 'api_list_pictures', methods: ['GET'])]
    public function list(PictureRepository $pictureRepository): Response
    {
        // 1st step is getting all the pictures from the repository
        $pictures = $pictureRepository->findAll();
        // We want to return the pictures to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $pictures,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_list_pictures']
        );
    }

    #[Route('/api/spot/{slug}/pictures', name: 'api_picture_by_spot', methods: ['GET'])]
    public function listBySpot(SpotRepository $spotRepository, $slug): Response
    {
        // Find the spot with the slug
        $spot = $spotRepository->findOneBy(['slug' => $slug]);

        // Check if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Spot non trouvé'], 404);
        }

        // Get the pictures associated with the spot
        $pictures = $spot->getPictures();

        // Check if there are pictures for the requested spot
        if (!$pictures) {
            return $this->json(['message' => 'Aucune image pour le spot sélectionné'], 404);
        }

        // Return the pictures associated with the picture
        return $this->json($pictures, 200, [], ['groups' => 'api_picture_by_spot']);
    }
    
    #[Route('/api/picture/upload', name: 'api_upload',  methods: ['POST'])]
    public function upload(Request $request, ParameterBagInterface $params, EntityManagerInterface $entity)
    {
        $image = $request->files->get('file');
				// enregistrement de l'image dans le dossier public du serveur
				// paramas->get('public') =>  va chercher dans services.yaml la variable public
        $image->move($params->get('pictures_directory'), $image->getClientOriginalName());

        // on ajoute uniqid() afin de ne pas avoir 2 fichiers avec le même nom
        $newFilename = uniqid().'.'. $image->getClientOriginalName();
        // ne pas oublier d'ajouter l'url de l'image dans l'entitée aproprié
				// $entity est l'entity qui doit recevoir votre image
				$entity->setImage($newFilename);

        return $this->json([
            'message' => 'Image uploaded successfully.'
        ]);
    }
}
