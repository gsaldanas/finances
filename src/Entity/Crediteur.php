<?php

namespace App\Entity;

use App\Repository\CrediteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CrediteurRepository::class)]
class Crediteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $voornaam = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $naam = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $straat_nr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postcode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gemeente = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $land = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $btw_nr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rek_nr = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Creditnota>
     */
    #[ORM\OneToMany(targetEntity: Creditnota::class, mappedBy: 'crediteur')]
    private Collection $creditnota;

    /**
     * @var Collection<int, Factuur>
     */
    #[ORM\OneToMany(targetEntity: Factuur::class, mappedBy: 'crediteur')]
    private Collection $factuur;

    /**
     * @var Collection<int, Betaling>
     */
    #[ORM\OneToMany(targetEntity: Betaling::class, mappedBy: 'crediteur')]
    private Collection $betaling;

    public function __construct()
    {
        $this->creditnota = new ArrayCollection();
        $this->factuur = new ArrayCollection();
        $this->betaling = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoornaam(): ?string
    {
        return $this->voornaam;
    }

    public function setVoornaam(?string $voornaam): static
    {
        $this->voornaam = $voornaam;

        return $this;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(?string $naam): static
    {
        $this->naam = $naam;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getStraatNr(): ?string
    {
        return $this->straat_nr;
    }

    public function setStraatNr(?string $straat_nr): static
    {
        $this->straat_nr = $straat_nr;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): static
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getGemeente(): ?string
    {
        return $this->gemeente;
    }

    public function setGemeente(?string $gemeente): static
    {
        $this->gemeente = $gemeente;

        return $this;
    }

    public function getLand(): ?string
    {
        return $this->land;
    }

    public function setLand(?string $land): static
    {
        $this->land = $land;

        return $this;
    }

    public function getBtwNr(): ?string
    {
        return $this->btw_nr;
    }

    public function setBtwNr(?string $btw_nr): static
    {
        $this->btw_nr = $btw_nr;

        return $this;
    }

    public function getRekNr(): ?string
    {
        return $this->rek_nr;
    }

    public function setRekNr(?string $rek_nr): static
    {
        $this->rek_nr = $rek_nr;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Creditnota>
     */
    public function getCreditnota(): Collection
    {
        return $this->creditnota;
    }

    public function addCreditnotum(Creditnota $creditnotum): static
    {
        if (!$this->creditnota->contains($creditnotum)) {
            $this->creditnota->add($creditnotum);
            $creditnotum->setCrediteur($this);
        }

        return $this;
    }

    public function removeCreditnotum(Creditnota $creditnotum): static
    {
        if ($this->creditnota->removeElement($creditnotum)) {
            // set the owning side to null (unless already changed)
            if ($creditnotum->getCrediteur() === $this) {
                $creditnotum->setCrediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Factuur>
     */
    public function getFactuur(): Collection
    {
        return $this->factuur;
    }

    public function addFactuur(Factuur $factuur): static
    {
        if (!$this->factuur->contains($factuur)) {
            $this->factuur->add($factuur);
            $factuur->setCrediteur($this);
        }

        return $this;
    }

    public function removeFactuur(Factuur $factuur): static
    {
        if ($this->factuur->removeElement($factuur)) {
            // set the owning side to null (unless already changed)
            if ($factuur->getCrediteur() === $this) {
                $factuur->setCrediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Betaling>
     */
    public function getBetaling(): Collection
    {
        return $this->betaling;
    }

    public function addBetaling(Betaling $betaling): static
    {
        if (!$this->betaling->contains($betaling)) {
            $this->betaling->add($betaling);
            $betaling->setCrediteur($this);
        }

        return $this;
    }

    public function removeBetaling(Betaling $betaling): static
    {
        if ($this->betaling->removeElement($betaling)) {
            // set the owning side to null (unless already changed)
            if ($betaling->getCrediteur() === $this) {
                $betaling->setCrediteur(null);
            }
        }

        return $this;
    }
}
