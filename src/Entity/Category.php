<?php

namespace App\Entity;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    public function __toString()
    {
        return $this->nom; // Supposons que "name" est le nom de l'auteur que vous voulez afficher.
    }
    #[Assert\NotBlank(message:"NOM must not be blank")]
    /**
 * @Assert\Regex(
 *     pattern="/^[A-Za-z\s]+$/",
 *     message="Nom must contain only letters and spaces"
 * )
 */


    #[ORM\Column(length: 50)]
    private ?string $nom = null;
    #[Assert\NotBlank(message:"Description must not be blank")]
    #[ORM\Column(length: 255)]
    private ?string $description = null;
    #[Assert\NotBlank(message:"Icon must not be blank")]
    #[ORM\Column(length: 50)]
    private ?string $icon = null;

   
    

    #[ORM\OneToMany(mappedBy: 'id_categorie', targetEntity: Service::class,cascade:["all"],orphanRemoval:true)]
    private Collection $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
       
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

     /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

   
   

   

}
