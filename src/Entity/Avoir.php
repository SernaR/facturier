<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: AvoirRepository::class)]
class Avoir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToOne(targetEntity: Facture::class)]
    private ?Facture $facture = null;

    #[ORM\OneToMany(mappedBy: 'avoir', targetEntity: LigneAvoir::class)]
    private Collection $ligneAvoir;

    //** Methods **//

    public function __construct()
    {
        $this->ligneAvoir = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * @return Collection|LigneAvoir[]
     */
    public function getLigneAvoir(): Collection
    {
        return $this->ligneAvoir;
    }

    public function addLigneAvoir(LigneAvoir $ligneAvoir): self
    {
        if (!$this->ligneAvoir->contains($ligneAvoir)) {
            $this->ligneAvoir[] = $ligneAvoir;
            $ligneAvoir->setAvoir($this);
        }

        return $this;
    }

    public function removeLigneAvoir(LigneAvoir $ligneAvoir): self
    {
        if ($this->ligneAvoir->contains($ligneAvoir)) {
            $this->ligneAvoir->removeElement($ligneAvoir);
            // set the owning side to null (unless already changed)
            if ($ligneAvoir->getAvoir() === $this) {
                $ligneAvoir->setAvoir(null);
            }
        }

        return $this;
    }
}
