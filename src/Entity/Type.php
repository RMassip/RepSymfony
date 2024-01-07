<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'Etre', targetEntity: Artiste::class)]
    private Collection $Etre;



    public function __construct()
    {
        $this->Etre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, Artiste>
     */
    public function getEtre(): Collection
    {
        return $this->Etre;
    }

    public function addEtre(Artiste $etre): self
    {
        if (!$this->Etre->contains($etre)) {
            $this->Etre->add($etre);
            $etre->setEtre($this);
        }

        return $this;
    }

    public function removeEtre(Artiste $etre): self
    {
        if ($this->Etre->removeElement($etre)) {
            // set the owning side to null (unless already changed)
            if ($etre->getEtre() === $this) {
                $etre->setEtre(null);
            }
        }

        return $this;
    }
}
