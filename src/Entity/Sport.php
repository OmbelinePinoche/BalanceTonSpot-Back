<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Spot::class, mappedBy: 'sport_id')]
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
            $spotId->addSportId($this);
        }

        return $this;
    }

    public function removeSpotId(Spot $spotId): static
    {
        if ($this->spot_id->removeElement($spotId)) {
            $spotId->removeSportId($this);
        }

        return $this;
    }
}
