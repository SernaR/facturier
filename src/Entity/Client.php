<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"advance", "invoice"}) 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"advance", "invoice"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"advance", "invoice"}) 
     */
    private $prenom;

    /**
     * @ORM\Column(type="text")
     * @Groups({"advance", "invoice"}) 
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advance", "invoice"}) 
     */
    private $societe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advance", "invoice"}) 
     */
    private $tvaIntracommunautaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ZoneGeographique", inversedBy="client")
     * @Groups({"advance", "invoice"}) 
     */
    private $zone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"advance", "invoice"}) 
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"advance", "invoice"}) 
     */
    private $mail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Devis", mappedBy="client")
     */
    private $devis;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(?string $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getTvaIntracommunautaire(): ?string
    {
        return $this->tvaIntracommunautaire;
    }

    public function setTvaIntracommunautaire(string $tvaIntracommunautaire): self
    {
        $this->tvaIntracommunautaire = $tvaIntracommunautaire;

        return $this;
    }

    public function getZone(): ?ZoneGeographique
    {
        return $this->zone;
    }

    public function setZone(?ZoneGeographique $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): self
    {
        if (!$this->devis->contains($devi)) {
            $this->devis[] = $devi;
            $devi->setClient($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->contains($devi)) {
            $this->devis->removeElement($devi);
            // set the owning side to null (unless already changed)
            if ($devi->getClient() === $this) {
                $devi->setClient(null);
            }
        }

        return $this;
    }
}
