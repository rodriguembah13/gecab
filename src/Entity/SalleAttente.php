<?php

namespace App\Entity;

use App\Repository\SalleAttenteRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalleAttenteRepository::class)
 */
class SalleAttente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class)
     */
    private $patient;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="time")
     */
    private $heureArrive;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heureFin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motif;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $createdBy;

    /**
     * SalleAttente constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getHeureArrive(): ?\DateTimeInterface
    {
        return $this->heureArrive;
    }

    public function setHeureArrive(\DateTimeInterface $heureArrive): self
    {
        $this->heureArrive = $heureArrive;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

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
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return SalleAttente
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

}
