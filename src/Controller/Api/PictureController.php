<?php

namespace App\Controller\Api;


use App\Entity\User;
use App\Repository\PictureRepository;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
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


    #[Route('/api/spot/{filename}', name: 'api_get_picture',  methods: ['GET'])]
    public function getSpotPicture(string $filename, ParameterBagInterface $params): BinaryFileResponse
    {
        // Construct the full file path using the pictures_directory parameter
        $filePath = $params->get('pictures_directory') . '/' . $filename;

        // Return the image file as a BinaryFileResponse
        return new BinaryFileResponse($filePath);
    }


    // #[Route('/api/profile/upload/{name}', name: 'api_profile_upload',  methods: ['POST'])]
    // public function uploadProfilePicture(Request $request, ParameterBagInterface $params, EntityManagerInterface $entityManager, User $user): JsonResponse
    // {
    //     /** @var User $user */
    //     $user = $this->getUser();

    //     // Check if the user exists
    //     if (!$user) {
    //         throw $this->createNotFoundException('Utilisateur introuvable');
    //     }

    //     $pictureFile = $request->files->get('profilPictureFile');

    //     // Check if a file was sent in the request
    //     if (!$pictureFile) {
    //         return $this->json([
    //             'error' => 'Aucun fichier envoyé'
    //         ], JsonResponse::HTTP_BAD_REQUEST);
    //     }

    //     // Move the file to the directory where pictures are stored
    //     $newFilename = uniqid() . '.' . $pictureFile->getClientOriginalExtension();
    //     $pictureFile->move($params->get('pictures_directory'), $pictureFile->getClientOriginalName());

    //     // Set the new filename in the user entity
    //     $user->setProfilPicture($newFilename);

    //     // Save the user entity to the database
    //     $entityManager->persist($user);

    //     // Flush changes to the database
    //     $entityManager->flush();

    //     return $this->json([
    //         'message' => 'Image ajoutée avec succès'
    //     ]);
    // }
}
