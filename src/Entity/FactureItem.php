<?php

namespace App\Entity;

use App\Repository\FactureItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureItemRepository::class)
 */
class FactureItem
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
    private $tva;
    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;
    /**
     * @ORM\Column(type="string")
     */
    private $item;
    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="factureItems")
     */
    private $facture;


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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     * @return FactureItem
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * @param mixed $tva
     * @return FactureItem
     */
    public function setTva($tva)
    {
        $this->tva = $tva;
        return $this;
    }

}
