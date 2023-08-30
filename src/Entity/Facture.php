<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToOne(targetEntity: Devis::class)]
    private ?Devis $devis = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $validation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $livraison = null;

    #[ORM\Column]
    private ?bool $payee = false;

    //private $acompte; //**obsolete**//

    #[ORM\OneToOne(targetEntity: Avoir::class)]
    private ?Avoir $avoir = null;

    #[ORM\OneToMany(mappedBy: 'facture', targetEntity: LigneFacture::class)]
    private Collection $ligneFacture;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finPrestation = null;

    #[ORM\Column]
    private ?bool $mensuel = false;

    //** Methods **//

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

//    public function getAcompte(): ?float
//    {
//        return $this->acompte;
//    }
//
//    public function setAcompte(?float $acompte): self
//    {
//        $this->acompte = $acompte;
//
//        return $this;
//    }

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
