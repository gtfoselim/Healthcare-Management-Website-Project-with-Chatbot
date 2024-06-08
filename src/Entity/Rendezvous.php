<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message:"full name is required")]
    /**
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z\s]+$/",
     *     message="Le nom complet ne doit contenir que des lettres et des espaces."
     * )
     */
    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

    #[Assert\NotBlank(message:"Phone number name is required")]
    /**
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="Le champ doit contenir uniquement des chiffres."
     * )
     */
     
    #[ORM\Column(length: 10)]
    private ?string $tel = null;

    
    #[Assert\NotBlank(message:"Date is required")]
    #[Assert\GreaterThanOrEqual('today')]  
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    
    

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

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[Assert\Email(message:"The email '{{ value }}' is not a valid email  ")]
    #[Assert\NotBlank(message:"email is required")]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'rendezvouses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Medecin $medecin = null;

    #[Assert\NotBlank(message:"time is required")]
    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

     


   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

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

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function __toString()
{
    return $this->fullname; // Supposons que "name" est le nom de l'auteur que vous voulez afficher.
}

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    #[ORM\OneToOne(mappedBy: 'rendezvous')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Rapport $rapport = null;

    // ... existing methods ...

    public function getRapport(): ?Rapport
    {
        return $this->rapport;
    }

    public function setRapport(?Rapport $rapport): static
    {
        $this->rapport = $rapport;

        return $this;
    }
    

   
}
