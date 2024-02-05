<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: spot::class, mappedBy: 'location_id')]
    private Collection $spot_id;

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
     * @return Collection<int, spot>
     */
    public function getSpotId(): Collection
    {
        return $this->spot_id;
    }

    public function addSpotId(spot $spotId): static
    {
        if (!$this->spot_id->contains($spotId)) {
            $this->spot_id->add($spotId);
            $spotId->setLocationId($this);
        }

        return $this;
    }

    public function removeSpotId(spot $spotId): static
    {
        if ($this->spot_id->removeElement($spotId)) {
            // set the owning side to null (unless already changed)
            if ($spotId->getLocationId() === $this) {
                $spotId->setLocationId(null);
            }
        }

        return $this;
    }
}
