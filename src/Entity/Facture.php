<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;
    /**
     * @ORM\Column(type="float")
     */
    private $totaltva;
    /**
     * @ORM\Column(type="float")
     */
    private $total;
    /**
     * @ORM\Column(type="float")
     */
    private $amountDue;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="factures")
     */
    private $createdBy;

    /**
     * @ORM\OneToMany(targetEntity=FactureItem::class, mappedBy="facture")
     */
    private $factureItems;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="factures")
     */
    private $patient;
    /**
     * @ORM\Column(type="string")
     */
    private $status;
    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;
    public function __construct()
    {
        $this->factureItems = new ArrayCollection();
        $this->status="encours";
        $this->createdAt=new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmountDue(): ?float
    {
        return $this->amountDue;
    }

    public function setAmountDue(float $amountDue): self
    {
        $this->amountDue = $amountDue;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection|FactureItem[]
     */
    public function getFactureItems(): Collection
    {
        return $this->factureItems;
    }

    public function addFactureItem(FactureItem $factureItem): self
    {
        if (!$this->factureItems->contains($factureItem)) {
            $this->factureItems[] = $factureItem;
            $factureItem->setFacture($this);
        }

        return $this;
    }

    public function removeFactureItem(FactureItem $factureItem): self
    {
        if ($this->factureItems->removeElement($factureItem)) {
            // set the owning side to null (unless already changed)
            if ($factureItem->getFacture() === $this) {
                $factureItem->setFacture(null);
            }
        }

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Facture
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Facture
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotaltva()
    {
        return $this->totaltva;
    }

    /**
     * @param mixed $totaltva
     * @return Facture
     */
    public function setTotaltva($totaltva)
    {
        $this->totaltva = $totaltva;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     * @return Facture
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

}
