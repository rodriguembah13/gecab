<?php

namespace App\Entity;

use App\Repository\AntecedantPatientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AntecedantPatientRepository::class)
 */
class AntecedantPatient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $antecedant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $groupe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $traitement;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateBegin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="antecedantPatients")
     */
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAntecedant(): ?string
    {
        return $this->antecedant;
    }

    public function setAntecedant(string $antecedant): self
    {
        $this->antecedant = $antecedant;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(?string $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getTraitement(): ?string
    {
        return $this->traitement;
    }

    public function setTraitement(?string $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(?\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

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
}
