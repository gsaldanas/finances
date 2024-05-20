<?php

namespace App\Entity;

use App\Repository\CreditnotaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditnotaRepository::class)]
class Creditnota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referentie = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datum = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $bedrag = null;

    #[ORM\ManyToOne(inversedBy: 'creditnota')]
    private ?Crediteur $crediteur = null;

    #[ORM\ManyToOne(inversedBy: 'creditnota')]
    private ?Debiteur $debiteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferentie(): ?string
    {
        return $this->referentie;
    }

    public function setReferentie(?string $referentie): static
    {
        $this->referentie = $referentie;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(?\DateTimeInterface $datum): static
    {
        $this->datum = $datum;

        return $this;
    }

    public function getBedrag(): ?string
    {
        return $this->bedrag;
    }

    public function setBedrag(?string $bedrag): static
    {
        $this->bedrag = $bedrag;

        return $this;
    }

    public function getCrediteur(): ?Crediteur
    {
        return $this->crediteur;
    }

    public function setCrediteur(?Crediteur $crediteur): static
    {
        $this->crediteur = $crediteur;

        return $this;
    }

    public function getDebiteur(): ?Debiteur
    {
        return $this->debiteur;
    }

    public function setDebiteur(?Debiteur $debiteur): static
    {
        $this->debiteur = $debiteur;

        return $this;
    }
}
