<?php

namespace App\Entity;

use App\Repository\ArtisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtisteRepository::class)]
class Artiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Chanson::class)]
    private Collection $Participer;

    #[ORM\ManyToOne(inversedBy: 'Etre')]
    private ?Type $Etre = null;


    public function __construct()
    {
        $this->Participer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeImmutable
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeImmutable $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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

    public function getEtre(): ?Type
    {
        return $this->Etre;
    }

    public function setEtre(?Type $Etre): self
    {
        $this->Etre = $Etre;

        return $this;
    }

    /**
     * @return Collection<int, Chanson>
     */
    public function getParticiper(): Collection
    {
        return $this->Participer;
    }

    public function addParticiper(Chanson $participer): self
    {
        if (!$this->Participer->contains($participer)) {
            $this->Participer->add($participer);
        }

        return $this;
    }

    public function removeParticiper(Chanson $participer): self
    {
        $this->Participer->removeElement($participer);

        return $this;
    }
}
