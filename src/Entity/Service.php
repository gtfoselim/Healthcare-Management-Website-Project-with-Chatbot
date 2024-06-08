<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    public function __toString()
    {
        return $this->nom; // Supposons que "name" est le nom de l'auteur que vous voulez afficher.
    }
    #[Assert\NotBlank(message:"nom must not be blank")]
   
    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[Assert\NotBlank(message:"description must not be blank")]
    #[ORM\Column(length: 255)]
    private ?string $description = null;
    #[Assert\GreaterThanOrEqual('today')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_cr = null;

   
    #[ORM\Column(length: 255 )]
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity:Category::class,inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    
    private ?Category $id_categorie=null  ;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'idserivce', targetEntity: Reservationservice::class, cascade:["all"], orphanRemoval:true)]
private Collection $idres;


    public function __construct()
    {
        $this->image = 4 ;
        $this->idres = new ArrayCollection();
       
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCr(): ?\DateTimeInterface
    {
        return $this->date_cr;
    }

    public function setDateCr(\DateTimeInterface $date_cr): static
    {
        $this->date_cr = $date_cr;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
   
    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getIdCategorie(): ?category
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?category $id_categorie): static
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Reservationservice>
     */
    public function getIdres(): Collection
    {
        return $this->idres;
    }

    public function addIdre(Reservationservice $idre): static
    {
        if (!$this->idres->contains($idre)) {
            $this->idres->add($idre);
            $idre->setIdserivce($this);
        }

        return $this;
    }

    public function removeIdre(Reservationservice $idre): static
    {
        if ($this->idres->removeElement($idre)) {
            // set the owning side to null (unless already changed)
            if ($idre->getIdserivce() === $this) {
                $idre->setIdserivce(null);
            }
        }

        return $this;
    }
}
