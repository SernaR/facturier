<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: PrestationRepository::class)]
class Prestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $montant= null;

    #[ORM\ManyToOne(targetEntity: TypeDeService::class, inversedBy: 'prestations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDeService $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDeFin = null;

    #[ORM\OneToMany(mappedBy: 'prestation', targetEntity: LigneDevis::class)]
    private Collection $ligneDevis;

    #[ORM\OneToMany(mappedBy: 'prestation', targetEntity: LigneFacture::class)]
    private Collection $ligneFacture;

    #[ORM\OneToMany(mappedBy: 'prestation', targetEntity: LigneAvoir::class)]
    private Collection $ligneAvoir;

    //** Methods **//

    public function __construct()
    {
        $this->ligneDevis = new ArrayCollection();
        $this->ligneFacture = new ArrayCollection();
        $this->ligneAvoir = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getType(): ?TypeDeService
    {
        return $this->type;
    }

    public function setType(?TypeDeService $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateDeFin(): ?\DateTimeInterface
    {
        return $this->dateDeFin;
    }

    public function setDateDeFin(?\DateTimeInterface $dateDeFin): self
    {
        $this->dateDeFin = $dateDeFin;

        return $this;
    }

    /**
     * @return Collection|LigneDevis[]
     */
    public function getLigneDevis(): Collection
    {
        return $this->ligneDevis;
    }

    public function addLigneDevi(LigneDevis $ligneDevi): self
    {
        if (!$this->ligneDevis->contains($ligneDevi)) {
            $this->ligneDevis[] = $ligneDevi;
            $ligneDevi->setPrestation($this);
        }

        return $this;
    }

    public function removeLigneDevi(LigneDevis $ligneDevi): self
    {
        if ($this->ligneDevis->contains($ligneDevi)) {
            $this->ligneDevis->removeElement($ligneDevi);
            // set the owning side to null (unless already changed)
            if ($ligneDevi->getPrestation() === $this) {
                $ligneDevi->setPrestation(null);
            }
        }

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
            $ligneFacture->setPrestation($this);
        }

        return $this;
    }

    public function removeLigneFacture(LigneFacture $ligneFacture): self
    {
        if ($this->ligneFacture->contains($ligneFacture)) {
            $this->ligneFacture->removeElement($ligneFacture);
            // set the owning side to null (unless already changed)
            if ($ligneFacture->getPrestation() === $this) {
                $ligneFacture->setPrestation(null);
            }
        }

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
            $ligneAvoir->setPrestation($this);
        }

        return $this;
    }

    public function removeLigneAvoir(LigneAvoir $ligneAvoir): self
    {
        if ($this->ligneAvoir->contains($ligneAvoir)) {
            $this->ligneAvoir->removeElement($ligneAvoir);
            // set the owning side to null (unless already changed)
            if ($ligneAvoir->getPrestation() === $this) {
                $ligneAvoir->setPrestation(null);
            }
        }

        return $this;
    }
}
