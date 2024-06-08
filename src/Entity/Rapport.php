<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Assert\NotBlank(message:"note is required")]
    /**
     * @Assert\Length(
     *      min=2,
     *      max=255,
     *      exactMessage="La note doit avoir exactement {{ limit }} caracteres."
     * )
     */
    #[ORM\Column(length: 255)]
    private ?string $note = null;

    #[ORM\OneToOne(cascade: ['persist','remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rendezvous $rendezvous = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getRendezvous(): ?Rendezvous
    {
        return $this->rendezvous;
    }

    public function setRendezvous(Rendezvous $rendezvous): static
    {
        $this->rendezvous = $rendezvous;
        

        return $this;
    }
}
