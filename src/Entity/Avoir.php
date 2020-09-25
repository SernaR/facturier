<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvoirRepository")
 */
class Avoir
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"debit"})
     */
    private $numero;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"debit"})
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture")
     * @Groups({"debit"})
     */
    private $facture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneAvoir", mappedBy="avoir", cascade={"persist", "remove"})
     * @Groups({"debit"})
     */
    private $ligneAvoir;

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
