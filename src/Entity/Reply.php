<?php

namespace App\Entity;

use App\Repository\ReplyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReplyRepository::class)]
#[ORM\Table(name: "reponse")] // Définir le nom de la table
class Reply
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: Reclamation::class, inversedBy: "replies")]
    #[ORM\JoinColumn(nullable: false, name: "reclamation_id", referencedColumnName: "id")]
    private $reclamation;

    #[ORM\Column(type: "string", length: 255, name: "author")]
    private $author;

    #[ORM\Column(type: "text", name: "response_content")]
    private $responseContent;

    #[ORM\Column(type: "datetime", name: "response_date")]
    private $responseDate;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getResponseContent(): ?string
    {
        return $this->responseContent;
    }

    public function setResponseContent(string $responseContent): self
    {
        $this->responseContent = $responseContent;

        return $this;
    }

    public function getResponseDate(): ?\DateTimeInterface
    {
        return $this->responseDate;
    }

    public function setResponseDate(\DateTimeInterface $responseDate): self
    {
        $this->responseDate = $responseDate;

        return $this;
    }
    
}