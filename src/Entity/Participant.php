<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Medecin;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateParticipation = null;

    #[ORM\ManyToOne(inversedBy: 'Participant')]
    private ?Evenement $Evenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "veuillez saisir description du participant ")]
    private ?string $description = null;


    /////////// tzid
    #[ORM\ManyToOne(inversedBy: 'Participant')]
    private ?Medecin $Medecin = null;
    /////////////////////

    public function __construct()
    {
        $this->dateParticipation = new \DateTime('now');
    }

    public function __toString()
    {
        return $this->dateParticipation;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateParticipation(): ?\DateTimeInterface
    {
        return $this->dateParticipation;
    }

    public function setDateParticipation(\DateTimeInterface $dateParticipation): static
    {
        $this->dateParticipation = $dateParticipation;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->Evenement;
    }

    public function setEvenement(?Evenement $Evenement): static
    {
        $this->Evenement = $Evenement;

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


    ///////////////////// tzid
    public function getMedecin(): ?Medecin
    {
        return $this->Medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->Medecin = $medecin;

        return $this;
    }
    ///////////////////////////////////
}
