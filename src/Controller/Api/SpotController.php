<?php

namespace App\Controller\Api;

use App\Entity\Location;
use App\Entity\Spot;
use App\Repository\LocationRepository;
use App\Repository\SpotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    #[Route('/api/spot/{slug}', name: 'api_edit_spot', methods: ['PUT'])]
    public function update(Spot $spot, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, SluggerInterface $slugger, $slug): Response
    {
        // Check if the spot exists
        if (!$spot) {
            // If not, send the message
            return $this->json(['message' => 'Aucun spot n\a été trouvé!'], 404);
        }

        // Retrieve the data send in the request PUT
        $data = $request->getContent();

        $updatedSpot = $serializer->deserialize($data, Spot::class, 'json', ['object_to_populate' => $spot]);

        // We can also update the slug if the name changes
        if ($updatedSpot->getName() !== $spot->getName()) {
            $slug = $slugger->slug($updatedSpot->getName());
            $updatedSpot->setSlug($slug);
        }

        $entityManager->persist($updatedSpot);
        $entityManager->flush();

        // Return to the updated spot
        return $this->json(['message' => 'Spot modifié avec succès!'], 200);
    }

    #[Route('/api/spots', name: 'api_add_spot', methods: ['POST'])]
    public function add(Request $request, Spot $spot, EntityManagerInterface $entityManager, SluggerInterface $slugger, SerializerInterface $serializer): Response
    {
        // Retrieve the data send in the POST request
        $data = json_decode($request->getContent(), true);

        // Create a new spot instance
        $spot = new Spot();

        // Set the properties from the given data
        $spot->setName($data['name']);
        $spot->setDescription($data['description']);

        // Find the location entity by its id in the database
        $location = $entityManager->getRepository(Location::class)->find($data['location_id']);

        $spot->setLocation($location);
        $spot->setAddress($data['address']);
        $spot->setPicture($data['picture']);

        // Generate the slug using the Slugger service
        $slug = $slugger->slug($data['name']);
        $spot->setSlug($slug);

        // We need to persist the spot entity to the database to save the data
        $entityManager->persist($spot);
        $entityManager->flush();

        return $this->json(['message' => 'Spot créé avec succès!'], 201,);
    }

    #[Route('/api/spot/{id}', name: 'api_delete', methods: ['DELETE'])]
    public function delete(Spot $spot = null, EntityManagerInterface $entityManager): Response
    {
        // Check if the spot exists
        if (!$spot) {
            return $this->json(['message' => 'Aucun spot n\'a été trouvé'], 404);
        }
        // Delete the data send in the request 
        $entityManager->remove($spot);
        $entityManager->flush();

        // Return the success message
        return $this->json(['message' => 'Spot supprimé avec succès!'], 200);
    }

    #[Route('/api/location/{slug}/spots', name: 'api_spot_by_location', methods: ['GET'])]
    public function spotByLocation(LocationRepository $locationRepository, $slug, Location $location = null): Response
    {
        // Get the spots from the entity Location
        $spots = $location->getSpotId();

        $location = $locationRepository->findOneBy(['slug' => $slug]);

        // Checks if the location exists
        if (!$location) {
            return $this->json(['message' => 'Lieu inconnu!'], 404);
        }

        // Checks if there is a spot in the requested location
        if (!$spots) {
            return $this->json(['message' => 'Aucun spot n\'a été trouvé!'], 404);
        }

        // Return all the spots according to the location
        return $this->json($spots, 200, [], ['groups' => 'api_spot_by_location']);
    }

}
