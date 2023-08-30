<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $envoi = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $annulation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $validation = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $discount = 0;

    #[ORM\OneToMany(mappedBy: 'devis', targetEntity: LigneDevis::class)]
    private Collection $ligneDevis;

    #[ORM\OneToOne(targetEntity: Accompte::class)]
    private ?Accompte $accompte = null;

    #[ORM\OneToOne(targetEntity: Facture::class)]
    private ?Facture $facture = null;

    //** Methods **//

    public function __construct()
    {
        $this->ligneDevis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEnvoi(): ?\DateTimeInterface
    {
        return $this->envoi;
    }

    public function setEnvoi(?\DateTimeInterface $envoi): self
    {
        $this->envoi = $envoi;

        return $this;
    }

    public function getAnnulation(): ?\DateTimeInterface
    {
        return $this->annulation;
    }

    public function setAnnulation(?\DateTimeInterface $annulation): self
    {
        $this->annulation = $annulation;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

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
            $ligneDevi->setDevis($this);
        }

        return $this;
    }

    public function removeLigneDevi(LigneDevis $ligneDevi): self
    {
        if ($this->ligneDevis->contains($ligneDevi)) {
            $this->ligneDevis->removeElement($ligneDevi);
            // set the owning side to null (unless already changed)
            if ($ligneDevi->getDevis() === $this) {
                $ligneDevi->setDevis(null);
            }
        }

        return $this;
    }

    public function getAccompte(): ?Accompte
    {
        return $this->accompte;
    }

    public function setAccompte(?Accompte $accompte): self
    {
        $this->accompte = $accompte;
        $accompte->setDevis($this);

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;
        $facture->setDevis($this);

        return $this;
    }
}
