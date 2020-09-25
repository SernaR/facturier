<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true) invoice
     * @Groups({"invoice", "debit"})
     */
    private $numero;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"invoice", "debit"})
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Devis")
     * @Groups({"invoice", "debit"})
     */
    private $devis;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"invoice", "debit"})
     */
    private $validation = null;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"invoice"})
     */
    private $livraison = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private $payee = false;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $acompte; //**obsolete**//

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Avoir", cascade={"persist", "remove"})
     */
    private $avoir;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneFacture", mappedBy="facture", cascade={"persist", "remove"})
     * @Groups({"invoice"})
     */
    private $ligneFacture;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $finPrestation;

    private $mensuel = false;

    public function __construct()
    {
        $this->ligneFacture = new ArrayCollection();
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

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): self
    {
        $this->devis = $devis;

        return $this;
    }

    public function getValidation(): ?\DateTimeInterface
    {
        return $this->validation;
    }

    public function setValidation(?\DateTimeInterface $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getLivraison(): ?\DateTimeInterface
    {
        return $this->livraison;
    }

    public function setLivraison(?\DateTimeInterface $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getPayee(): ?bool
    {
        return $this->payee;
    }

    public function setPayee(bool $payee): self
    {
        $this->payee = $payee;

        return $this;
    }

    public function getAcompte(): ?float
    {
        return $this->acompte;
    }

    public function setAcompte(?float $acompte): self
    {
        $this->acompte = $acompte;

        return $this;
    }

    public function getAvoir(): ?Avoir
    {
        return $this->avoir;
    }

    public function setAvoir(?Avoir $avoir): self
    {
        $this->avoir = $avoir;
        $avoir->setFacture($this);

        return $this;
    }

    /**
     * @return Collection|LigneFacture[]
     */
    public function getLigneFacture(): Collection
    {
        return $this->ligneFacture;
    }

    public function addLigneFacture(LigneFacture $ligneFacture): self
    {
        if (!$this->ligneFacture->contains($ligneFacture)) {
            $this->ligneFacture[] = $ligneFacture;
            $ligneFacture->setFacture($this);
        }

        return $this;
    }

    public function removeLigneFacture(LigneFacture $ligneFacture): self
    {
        if ($this->ligneFacture->contains($ligneFacture)) {
            $this->ligneFacture->removeElement($ligneFacture);
            // set the owning side to null (unless already changed)
            if ($ligneFacture->getFacture() === $this) {
                $ligneFacture->setFacture(null);
            }
        }

        return $this;
    }

    public function getFinPrestation(): ?\DateTimeInterface
    {
        return $this->finPrestation;
    }

    public function setFinPrestation(?\DateTimeInterface $finPrestation): self
    {
        $this->finPrestation = $finPrestation;

        return $this;
    }

    public function getMensuel(): ?bool
    {
        return $this->mensuel;
    }

    public function setMensuel(?bool $mensuel): self
    {
        $this->mensuel = $mensuel;

        return $this;
    }

}    