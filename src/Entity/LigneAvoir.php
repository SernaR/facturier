<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneAvoirRepository")
 */
class LigneAvoir
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite = 1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Avoir", inversedBy="ligneAvoir")
     */
    private $avoir;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Prestation", inversedBy="ligneAvoir")
     */
    private $prestation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getAvoir(): ?Avoir
    {
        return $this->avoir;
    }

    public function setAvoir(?Avoir $avoir): self
    {
        $this->avoir = $avoir;

        return $this;
    }

    public function getPrestation(): ?Prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?Prestation $prestation): self
    {
        $this->prestation = $prestation;

        return $this;
    }
}
