<?php

namespace App\Entity;

use App\Repository\ReservationserviceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationserviceRepository::class)]
class Reservationservice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
   
    
    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(targetEntity:Service::class,inversedBy: 'idres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $idserivce = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getIdserivce(): ?Service
    {
        return $this->idserivce;
    }

    public function setIdserivce(?Service $idserivce): static
    {
        $this->idserivce = $idserivce;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom ?? ''; // Adjust this according to your entity structure.
    }
}
