<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: LigneAvoirRepository::class)]
class LigneAvoir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = 1;

    #[ORM\ManyToOne(targetEntity: Avoir::class, inversedBy: 'ligneAvoir')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Avoir $avoir = null;

    #[ORM\ManyToOne(targetEntity: Prestation::class, inversedBy: 'ligneAvoir')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prestation $prestation = null;

    //** Methods **//

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
