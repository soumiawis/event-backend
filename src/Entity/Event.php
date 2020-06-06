<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *     normalizationContext = {
 *          "groups" = {"event"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"artist", "event", "categorie"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @assert\NotBlank
     * @Groups({"artist","event", "categorie"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @assert\NotBlank
     * @Groups({"artist","event", "categorie"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"artist","event", "categorie"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"artist","event", "categorie"})
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     * @assert\NotBlank
     * @Groups({"artist","event", "categorie"})
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     * @assert\NotBlank
     * @Groups({"event"})
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     * @assert\NotBlank
     *
     */
    private $artist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }
}
