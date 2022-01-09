<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Isbn(
     *     type = "isbn13",
     *     message = "This isbn value is not valid."
     * )
     * @Assert\NotBlank
     */
    private $isdn;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $nombre_pages;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $date_de_parution;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      notInRangeMessage = "You must enter a note between {{ min }} and {{ max }}",
     * )
     * @Assert\NotBlank
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity=Auteur::class, inversedBy="livres")
     * @Assert\NotBlank
     */
    private $auteur;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="livres")
     * @Assert\NotBlank
     */
    private $genre;

    public function __construct()
    {
        $this->auteur = new ArrayCollection();
        $this->genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsdn(): ?string
    {
        return $this->isdn;
    }

    public function setIsdn(string $isdn): self
    {
        $this->isdn = $isdn;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNombrePages(): ?int
    {
        return $this->nombre_pages;
    }

    public function setNombrePages(int $nombre_pages): self
    {
        $this->nombre_pages = $nombre_pages;

        return $this;
    }

    public function getDateDeParution(): ?\DateTimeInterface
    {
        return $this->date_de_parution;
    }

    public function setDateDeParution(\DateTimeInterface $date_de_parution): self
    {
        $this->date_de_parution = $date_de_parution;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */
    public function getAuteur(): Collection
    {
        return $this->auteur;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->auteur->contains($auteur)) {
            $this->auteur[] = $auteur;
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        $this->auteur->removeElement($auteur);

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->titre." :: ".$this->isdn;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
