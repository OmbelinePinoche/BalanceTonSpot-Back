<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[Groups(['api_list_location', 'api_show_location'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['api_list_location', 'api_show_location', 'list', 'show', 'api_list', 'api_show', 'api_show_by_sport', 'show_by_sport'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['api_list_location', 'api_show_location'])]
    #[ORM\OneToMany(targetEntity: Spot::class, mappedBy: 'location', orphanRemoval: true)]
    private Collection $spot_id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->spot_id = new ArrayCollection();
    }
  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return Collection<int, Spot>
     */
   
    public function getSpotId(): Collection
    {
        return $this->spot_id;
    }

    public function addSpotId(Spot $spotId): static
    {
        if (!$this->spot_id->contains($spotId)) {
            $this->spot_id->add($spotId);
            $spotId->setLocation($this);
        }

        return $this;
    }

    public function removeSpotId(Spot $spotId): static
    {
        if ($this->spot_id->removeElement($spotId)) {
            // set the owning side to null (unless already changed)
            if ($spotId->getLocation() === $this) {
                $spotId->setLocation(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
