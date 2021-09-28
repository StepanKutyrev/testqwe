<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostsRepository::class)
 */
class Posts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $image_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $date;

    /**
     * @ORM\Column(type="datetime")
     */
    public $trueDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->image_name;
    }

    public function setImageName(string $image_name): self
    {
        $this->image_name = $image_name;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTrueDate(): ?\DateTimeInterface
    {
        return $this->trueDate;
    }

    public function setTrueDate(\DateTimeInterface $trueDate): self
    {
        $this->trueDate = $trueDate;
        return $this;
    }
}
