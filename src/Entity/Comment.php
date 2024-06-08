<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Post;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_comment = null;

    #[ORM\Column(length: 1000)]
    #[Assert\NotBlank(message:"Comment must not be blank")]
    #[Assert\Length(min: 5, minMessage: "Name must be at least {{ limit }} characters long")]
    private ?string $contenu_comment = null;

    #[ORM\Column(nullable: true)]
    private ?int $likes_comment = null;

    #[ORM\Column(nullable: true)]
    private ?int $dislikes_comment = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Name must not be blank")]
    #[Assert\Length(min: 3, minMessage: "Name must be at least {{ limit }} characters long")]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: "Name must contain only letters"
    )]
    private ?string $name_comment = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Mail must not be blank")]
    #[Assert\Email(message: "Please enter a valid email address")]
    private ?string $mail_comment = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datecreation_comment = null;

    #[ORM\ManyToOne(inversedBy: 'id_comment')]
    private ?post $id_post = null;

    public function __construct()
    {
       
        $this->likes_comment=0;
        $this->dislikes_comment=0;
        

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdComment(): ?int
    {
        return $this->id_comment;
    }

    public function setIdComment(int $id_comment): static
    {
        $this->id_comment = $id_comment;

        return $this;
    }

    public function getContenuComment(): ?string
    {
        return $this->contenu_comment;
    }

    public function setContenuComment(string $contenu_comment): static
    {
        $this->contenu_comment = $contenu_comment;

        return $this;
    }

    public function getLikesComment(): ?int
    {
        return $this->likes_comment;
    }

    public function setLikesComment(?int $likes_comment): static
    {
        $this->likes_comment = $likes_comment;

        return $this;
    }

    public function getDislikesComment(): ?int
    {
        return $this->dislikes_comment;
    }

    public function setDislikesComment(?int $dislikes_comment): static
    {
        $this->dislikes_comment = $dislikes_comment;

        return $this;
    }

    public function getNameComment(): ?string
    {
        return $this->name_comment;
    }

    public function setNameComment(string $name_comment): static
    {
        $this->name_comment = $name_comment;

        return $this;
    }

    public function getMailComment(): ?string
    {
        return $this->mail_comment;
    }

    public function setMailComment(string $mail_comment): static
    {
        $this->mail_comment = $mail_comment;

        return $this;
    }

    public function getDatecreationComment(): ?\DateTimeInterface
    {
        return $this->datecreation_comment;
    }

    public function setDatecreationComment(?\DateTimeInterface $datecreation_comment): static
    {
        $this->datecreation_comment = $datecreation_comment;

        return $this;
    }

    public function getIdPost(): ?post
    {
        return $this->id_post;
    }

    public function setIdPost(?post $id_post): static
    {
        $this->id_post = $id_post;

        return $this;
    }
}
