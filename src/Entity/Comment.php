<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?users $name = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?spot $spot_id = null;

    #[ORM\ManyToOne(inversedBy: 'comment_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getName(): ?users
    {
        return $this->name;
    }

    public function setName(?users $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSpotId(): ?spot
    {
        return $this->spot_id;
    }

    public function setSpotId(?spot $spot_id): static
    {
        $this->spot_id = $spot_id;

        return $this;
    }

    public function getUserId(): ?users
    {
        return $this->user_id;
    }

    public function setUserId(?users $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
