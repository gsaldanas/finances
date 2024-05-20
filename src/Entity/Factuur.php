<?php

namespace App\Entity;

use App\Repository\FactuurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactuurRepository::class)]
class Factuur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referentie = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datum = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $verval_datum = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $bedrag = null;

    #[ORM\Column]
    private ?bool $is_betaald = null;

    #[ORM\ManyToOne(inversedBy: 'factuur')]
    private ?Crediteur $crediteur = null;

    #[ORM\ManyToOne(inversedBy: 'factuur')]
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

    public function getVervalDatum(): ?\DateTimeInterface
    {
        return $this->verval_datum;
    }

    public function setVervalDatum(?\DateTimeInterface $verval_datum): static
    {
        $this->verval_datum = $verval_datum;

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

    public function isBetaald(): ?bool
    {
        return $this->is_betaald;
    }

    public function setBetaald(bool $is_betaald): static
    {
        $this->is_betaald = $is_betaald;

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
