<?php

namespace App\Entity;

use App\Repository\SpotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: SpotRepository::class)]
class Spot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api_list', 'api_show', 'api_spot_by_location', 'api_show_by_sport', 'api_favorites_list'])]
    private ?int $id = null;

    #[Groups(['api_list', 'api_show', 'api_spot_by_location', 'api_show_by_sport', 'api_list_sport', 'api_list_location', 'api_favorites_list', 'api_list_pictures', 'api_list_comment', 'api_show_comment'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    
    #[Groups(['api_list',  'api_show', 'api_spot_by_location', 'api_show_by_sport', 'api_favorites_list'])]
    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[Groups(['api_list', 'api_show', 'api_spot_by_location', 'api_show_by_sport', 'api_favorites_list'])]
    #[ORM\Column(length: 500)]
    private ?string $picture = null;

    #[Groups(['api_list', 'api_show', 'api_spot_by_location', 'api_show_by_sport', 'api_favorites_list'])]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[Groups(['api_list', 'api_show', 'api_spot_by_location', 'api_show_by_sport', 'api_favorites_list'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: 1, nullable: true)]
    private ?string $rating = null;

    #[Groups(['api_list', 'api_show', 'api_spot_by_location', 'spot_by_location', 'api_favorites_list'])]
    #[ORM\ManyToMany(targetEntity: Sport::class, inversedBy: 'spot_id')]
    private Collection $sport_id;

    #[Groups(['api_list', 'api_show', 'api_show_by_sport', 'show_by_sport', 'api_favorites_list'])]
    #[ORM\ManyToOne(inversedBy: 'spot_id', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[Groups(['api_show'])]
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'spot')]
    private Collection $comments;

    #[Groups(['show','api_show'])]
    #[ORM\OneToMany(targetEntity: Picture::class, mappedBy: 'spot', orphanRemoval: true)]
    private Collection $pictures;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favorites')]
    private Collection $user_favorite;

    public function __construct()
    {
        $this->sport_id = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->user_favorite = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(?string $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, Sport>
     */
    public function getSportId(): Collection
    {
        return $this->sport_id;
    }

    public function addSportId(Sport $sportId): static
    {
        if (!$this->sport_id->contains($sportId)) {
            $this->sport_id->add($sportId);
        }

        return $this;
    }

    public function removeSportId(Sport $sportId): static
    {
        $this->sport_id->removeElement($sportId);

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setSpot($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getSpot() === $this) {
                $comment->setSpot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setSpot($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getSpot() === $this) {
                $picture->setSpot(null);
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

    /**
     * @return Collection<int, User>
     */
    public function getUserFavorite(): Collection
    {
        return $this->user_favorite;
    }

    public function addUserFavorite(User $userFavorite): static
    {
        if (!$this->user_favorite->contains($userFavorite)) {
            $this->user_favorite->add($userFavorite);
            $userFavorite->addFavorite($this);
        }

        return $this;
    }

    public function removeUserFavorite(User $userFavorite): static
    {
        if ($this->user_favorite->removeElement($userFavorite)) {
            $userFavorite->removeFavorite($this);
        }

        return $this;
    }
}
