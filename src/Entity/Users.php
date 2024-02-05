<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $name = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $firstname = null;

    
    #[ORM\Column(length: 64, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 120)]
    private ?string $role = null;

    #[ORM\Column(length: 60)]
    private ?string $email = null;

    #[ORM\Column(length: 60)]
    private ?string $password = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 64)]
    private ?string $username = null;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'name')]
    private Collection $comments;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user_id')]
    private Collection $comment_id;

    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $spot_id;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->comment_id = new ArrayCollection();
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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
            $comment->setName($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getName() === $this) {
                $comment->setName(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getCommentId(): Collection
    {
        return $this->comment_id;
    }

    public function addCommentId(Comment $commentId): static
    {
        if (!$this->comment_id->contains($commentId)) {
            $this->comment_id->add($commentId);
            $commentId->setUserId($this);
        }

        return $this;
    }

    public function removeCommentId(Comment $commentId): static
    {
        if ($this->comment_id->removeElement($commentId)) {
            // set the owning side to null (unless already changed)
            if ($commentId->getUserId() === $this) {
                $commentId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSpotId(): Collection
    {
        return $this->spot_id;
    }

    public function addSpotId(self $spotId): static
    {
        if (!$this->spot_id->contains($spotId)) {
            $this->spot_id->add($spotId);
        }

        return $this;
    }

    public function removeSpotId(self $spotId): static
    {
        $this->spot_id->removeElement($spotId);

        return $this;
    }
}
