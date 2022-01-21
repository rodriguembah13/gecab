<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RendezvousRepository::class)
 */
class Rendezvous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRdv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $medecin;
    /**
     * @ORM\ManyToOne(targetEntity=Patient::class)
     */
    private $patient;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Rendezvous constructor.
     */
    public function __construct()
    {
        $this->status="encours";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->dateRdv;
    }

    public function setDateRdv(?\DateTimeInterface $dateRdv): self
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
     * @return Rendezvous
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMedecin()
    {
        return $this->medecin;
    }

    /**
     * @param mixed $medecin
     * @return Rendezvous
     */
    public function setMedecin($medecin)
    {
        $this->medecin = $medecin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param mixed $patient
     * @return Rendezvous
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
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
     * @return Rendezvous
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Rendezvous
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

}
