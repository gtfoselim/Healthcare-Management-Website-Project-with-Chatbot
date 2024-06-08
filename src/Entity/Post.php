<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Id post must not be blank")]
    private ?int $id_post = null;
    
    #[ORM\Column(length: 255)]
    private ?string $type_post = null;
    
    #[ORM\Column(length: 1000)]
    #[Assert\NotBlank(message:"The Title must not be blank")]
    #[Assert\Length(min: 10, minMessage: "Name must be at least {{ limit }} characters long")]
    private ?string $title_post = null;
    
    #[ORM\Column(length: 8000)]
    #[Assert\NotBlank(message:"Post Contenu must not be blank")]
    #[Assert\Length(min: 30, minMessage: "Name must be at least {{ limit }} characters long")]
    private ?string $contenu_post = null;

    #[ORM\Column(nullable: true)]
    private ?int $nb_comments_post = null;

    #[ORM\Column(nullable: true)]
    private ?bool $validation_post = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $makedate_post = null;

    #[ORM\Column(nullable: true)]
    private ?int $likes_post = null;

    #[ORM\Column(nullable: true)]
    private ?int $dislikes_post = null;

    #[ORM\OneToMany(mappedBy: 'id_post', targetEntity: Comment::class, cascade: ['remove'])]
    private Collection $id_comment;

    public function __construct()
    {   
        $this->id_comment = new ArrayCollection();
        $this->nb_comments_post=0;
        $this->likes_post=0;
        $this->dislikes_post=0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPost(): ?int
    {
        return $this->id_post;
    }

    public function setIdPost(int $id_post): static
    {
        $this->id_post = $id_post;

        return $this;
    }

    public function getTypePost(): ?string
    {
        return $this->type_post;
    }

    public function setTypePost(string $type_post): static
    {
        $this->type_post = $type_post;

        return $this;
    }

    public function getTitlePost(): ?string
    {
        return $this->title_post;
    }

    public function setTitlePost(string $title_post): static
    {
        $this->title_post = $title_post;

        return $this;
    }

    public function getContenuPost(): ?string
    {
        return $this->contenu_post;
    }

    public function setContenuPost(string $contenu_post): static
    {
        $this->contenu_post = $contenu_post;

        return $this;
    }

    public function getNbCommentsPost(): ?int
    {
        return $this->nb_comments_post;
    }

    public function setNbCommentsPost(?int $nb_comments_post): static
    {
        $this->nb_comments_post = $nb_comments_post;

        return $this;
    }

    public function isValidationPost(): ?bool
    {
        return $this->validation_post;
    }

    public function setValidationPost(?bool $validation_post): static
    {
        $this->validation_post = $validation_post;

        return $this;
    }

    public function getMakedatePost(): ?\DateTimeInterface
    {
        return $this->makedate_post;
    }

    public function setMakedatePost(?\DateTimeInterface $makedate_post): static
    {
        $this->makedate_post = $makedate_post;

        return $this;
    }

    public function getLikesPost(): ?int
    {
        return $this->likes_post;
    }

    public function setLikesPost(?int $likes_post): static
    {
        $this->likes_post = $likes_post;

        return $this;
    }

    public function getDislikesPost(): ?int
    {
        return $this->dislikes_post;
    }

    public function setDislikesPost(?int $dislikes_post): static
    {
        $this->dislikes_post = $dislikes_post;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getIdComment(): Collection
    {
        return $this->id_comment;
    }

    public function addIdComment(Comment $idComment): static
    {
        if (!$this->id_comment->contains($idComment)) {
            $this->id_comment->add($idComment);
            $idComment->setIdPost($this);
        }

        return $this;
    }

    public function removeIdComment(Comment $idComment): static
    {
        if ($this->id_comment->removeElement($idComment)) {
            // set the owning side to null (unless already changed)
            if ($idComment->getIdPost() === $this) {
                $idComment->setIdPost(null);
            }
        }

        return $this;
    }
}
