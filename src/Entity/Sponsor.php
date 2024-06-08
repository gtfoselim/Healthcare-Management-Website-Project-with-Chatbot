<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5)]
    #[Assert\Length(max: 20)]
    #[Assert\NotBlank(message: "veuillez saisir le nom du sponsor ")]
    private ?string $nomSponsor = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5)]
    #[Assert\Length(max: 20)]
    #[Assert\NotBlank(message: "veuillez saisir la description ")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Assert\NotBlank(message: "veuillez saisir la email ")]
    private ?string $emailSponsor = null;

    #[ORM\OneToMany(mappedBy: 'Sponsor', targetEntity: Evenement::class)]
    private Collection $Evenement;

    public function __construct()
    {
        $this->Evenement = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nomSponsor;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSponsor(): ?string
    {
        return $this->nomSponsor;
    }

    public function setNomSponsor(string $nomSponsor): static
    {
        $this->nomSponsor = $nomSponsor;

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

    public function getEmailSponsor(): ?string
    {
        return $this->emailSponsor;
    }

    public function setEmailSponsor(string $emailSponsor): static
    {
        $this->emailSponsor = $emailSponsor;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenement(): Collection
    {
        return $this->Evenement;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->Evenement->contains($evenement)) {
            $this->Evenement->add($evenement);
            $evenement->setSponsor($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->Evenement->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getSponsor() === $this) {
                $evenement->setSponsor(null);
            }
        }

        return $this;
    }
}
