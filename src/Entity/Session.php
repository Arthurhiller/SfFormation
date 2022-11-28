<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
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
    private $intitule;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlace;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPlaceReserve;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlaceDisponible;

    /**
     * @ORM\Column(type="text")
     */
    private $detailProgramme;

    /**
     * @ORM\ManyToMany(targetEntity=Programme::class, inversedBy="sessions")
     */
    private $programmes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->programmes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

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

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getNbPlaceReserve(): ?int
    {
        return $this->nbPlaceReserve;
    }

    public function setNbPlaceReserve(?int $nbPlaceReserve): self
    {
        $this->nbPlaceReserve = $nbPlaceReserve;

        return $this;
    }

    public function getNbPlaceDisponible(): ?int
    {
        return $this->nbPlaceDisponible;
    }

    public function setNbPlaceDisponible(int $nbPlaceDisponible): self
    {
        $this->nbPlaceDisponible = $nbPlaceDisponible;

        return $this;
    }

    public function getDetailProgramme(): ?string
    {
        return $this->detailProgramme;
    }

    public function setDetailProgramme(string $detailProgramme): self
    {
        $this->detailProgramme = $detailProgramme;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): self
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes[] = $programme;
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        $this->programmes->removeElement($programme);

        return $this;
    }
}
