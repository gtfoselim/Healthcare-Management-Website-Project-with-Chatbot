<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private  $imageEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5)]
    #[Assert\Length(max: 20)]
    #[Assert\NotBlank(message: "veuillez saisir le Type de l'evenement ")]
    private ?string $typeEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5)]
    #[Assert\Length(max: 20)]
    #[Assert\NotBlank(message: "veuillez saisir le Nom de l'evenement ")]
    private ?string $nomEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3)]
    #[Assert\Length(max: 20)]
    #[Assert\NotBlank(message: "veuillez saisir le Lieu de l'evenement ")]
    private ?string $lieuEvenement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "veuillez saisir le Date Debut de l'evenement ")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "veuillez saisir le Date Fin de l'evenement ")]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    #[Assert\Length(max: 3)]
    #[Assert\NotBlank(message: "veuillez saisir le Nombre de Participant dans l'evenement ")]
    private ?int $nbParticipants = null;

    #[ORM\OneToMany(mappedBy: 'Evenement', targetEntity: Participant::class)]
    private Collection $Participant;

    #[ORM\ManyToOne(inversedBy: 'Evenement')]
    private ?Sponsor $Sponsor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Color = null;

    public function __construct()
    {
        $this->Participant = new ArrayCollection();
        $this->dateDebut = new \DateTime('now');
        $this->dateFin = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageEvenement()
    {
        return $this->imageEvenement;
    }

    public function setImageEvenement($imageEvenement)
    {
        $this->imageEvenement = $imageEvenement;

        return $this;
    }

    public function getTypeEvenement(): ?string
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(string $typeEvenement): static
    {
        $this->typeEvenement = $typeEvenement;

        return $this;
    }

    public function getNomEvenement(): ?string
    {
        return $this->nomEvenement;
    }

    public function setNomEvenement(string $nomEvenement): static
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    public function getLieuEvenement(): ?string
    {
        return $this->lieuEvenement;
    }

    public function setLieuEvenement(string $lieuEvenement): static
    {
        $this->lieuEvenement = $lieuEvenement;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNbParticipants(): ?int
    {
        return $this->nbParticipants;
    }

    public function setNbParticipants(int $nbParticipants): static
    {
        $this->nbParticipants = $nbParticipants;

        return $this;
    }


    /**
     * @return Collection<int, Participant>
     */
    public function getParticipant(): Collection
    {
        return $this->Participant;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->Participant->contains($participant)) {
            $this->Participant->add($participant);
            $participant->setEvenement($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->Participant->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getEvenement() === $this) {
                $participant->setEvenement(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nomEvenement;
    }

    public function getSponsor(): ?Sponsor
    {
        return $this->Sponsor;
    }

    public function setSponsor(?Sponsor $Sponsor): static
    {
        $this->Sponsor = $Sponsor;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(?string $Color): static
    {
        $this->Color = $Color;

        return $this;
    }
}
