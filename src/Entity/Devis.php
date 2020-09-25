<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
 */
class Devis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"advance", "invoice", "quotation"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *  @Groups({"invoice", "quotation"})
     */
    private $envoi;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $annulation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="devis")
     *  @Groups({"advance", "invoice", "quotation", "debit"})
     */
    private $client;

    /**
     * @ORM\Column(type="float")
     * @Groups({"invoice", "quotation", "debit"})
     */
    private $discount = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneDevis", mappedBy="devis", cascade={"persist", "remove"})
     * @Groups({"quotation"})
     */
    private $ligneDevis;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Accompte", cascade={"persist", "remove"})
     * @Groups({"invoice", "debit"})
     */
    private $accompte;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", cascade={"persist", "remove"})
     */
    private $facture;

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
