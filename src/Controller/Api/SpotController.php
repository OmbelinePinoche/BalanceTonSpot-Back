<?php

namespace App\Controller\Api;

use App\Entity\Spot;
use App\Entity\Location;
use App\Form\SpotRatingType;
use App\Repository\SpotRepository;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpotController extends AbstractController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    #[Route('/api/spots', name: 'api_list', methods: ['GET'])]
    public function list(SpotRepository $spotRepository): Response
    { 
        // 1st step is getting all the spots from the repository
        $spots = $spotRepository->findAll();
        // We want to return the spots to the view
        // $this->json method allows the conversion of a PHP object to a JSON object
        return $this->json(
            // 1st param: what we want to display
            $spots,
            // 2nd param: status code
            200,
            // 3rd param: header
            [],
            // 4th param: groups (defines which elements of the entity we want to display)
            ['groups' => 'api_list']
        );
    }
    
    #[Route('/api/spot/{slug}', name: 'api_show', methods: ['GET'])]
    public function show(SpotRepository $spotRepository, $slug): Response
    {
        $spot = $spotRepository->findOneBy(['slug' => $slug]);

        if (!$spot) {
            return $this->json(['message' => 'Aucun spot n\a été trouvé!'], 404);
        }

        // $spot->setSlug($this->slugger->slug($spot->getName()));

        return $this->json($spot, 200, [], ['groups' => 'api_show']);
    }

    /**
     * /* @Route("/api/spot/{slug}/rate", name="api_spot_rate", methods={"POST"}) */
     
    public function rate(Request $request, Spot $spot): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        // Create the form
        $form = $this->createForm(SpotRatingType::class);
        $form->submit($data);
        
        // Check if the form is valid
        if ($form->isValid()) {
            $rating = $form->get('rating')->getData();
            
            // Save the rating in the database or any other necessary processing
            
            return new JsonResponse(['success' => true]);
        }
        
        // If the form is not valid, return the errors
        $errors = ["Qu'est ce que tu as fais de ce maudit pancake, tabarnak!"];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }
        
        return new JsonResponse(['success' => false, 'errors' => $errors], 400);
    }
}
