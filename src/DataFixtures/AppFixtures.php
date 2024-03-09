<?php

namespace App\DataFixtures;

use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{

    // private $slugger;

    // public function __construct(SluggerInterface $slugger)
    // {
    //     $this->slugger = $slugger;
    // }

    public function load(ObjectManager $manager): void
    {
        // $sport = new Sport();
        // $sport->setSlug($this->slugger->slug($sport->getName()));
        // $manager->persist($sport);
        // $manager->flush();
    }
}

