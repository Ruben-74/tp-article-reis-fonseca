<?php

namespace App\Entity;

use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * 
 * @UniqueEntity(
 * fields={"libelle"},
 * message= "Un autre utilisateur a deja créer un article avec le meme libelle"
 * )
 * 
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=50, minMessage="Votre description doit faire au moins 5 caracteres")
     */
    private $libelle;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     *  @Assert\Length(min=0, max=500, minMessage="Votre prix doit etre compris entre 0 et 500 euros ")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", nullable=false)
     *  @Assert\Length(min=10, max=200, minMessage="Votre description doit faire au moins 10 caracteres ")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Votre image doit etre une url ")
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
