<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsultationRepository::class)
 */
class Consultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $motif;
    /**
     * @ORM\Column(type="text", length=255)
     */
    private $dianostique;
    /**
     * @ORM\ManyToOne(targetEntity=Patient::class)
     */
    private $patient;
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $medecin;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $createdBy;
    /**
     * @ORM\Column(type="float", length=255,nullable=true)
     */
    private $temperature;
    /**
     * @ORM\Column(type="float", length=255,nullable=true)
     */
    private $poids;
    /**
     * @ORM\Column(type="float", length=255,nullable=true)
     */
    private $taille;
    /**
     * @ORM\Column(type="float", length=255,nullable=true)
     */
    private $pools;
    /**
     * @ORM\Column(type="float", length=255,nullable=true)
     */
    private $creatine;
    /**
     * @ORM\Column(type="float", length=255,nullable=true)
     */
    private $uree;

    /**
     * Consultation constructor.
     */
    public function __construct()
    {
        $this->status="complete";
        $this->createdAt=new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * @param mixed $motif
     * @return Consultation
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDianostique()
    {
        return $this->dianostique;
    }

    /**
     * @param mixed $dianostique
     * @return Consultation
     */
    public function setDianostique($dianostique)
    {
        $this->dianostique = $dianostique;
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
     * @return Consultation
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
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
     * @return Consultation
     */
    public function setMedecin($medecin)
    {
        $this->medecin = $medecin;
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
     * @return Consultation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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
     * @return Consultation
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     * @return Consultation
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param mixed $temperature
     * @return Consultation
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * @param mixed $poids
     * @return Consultation
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param mixed $taille
     * @return Consultation
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPools()
    {
        return $this->pools;
    }

    /**
     * @param mixed $pools
     * @return Consultation
     */
    public function setPools($pools)
    {
        $this->pools = $pools;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatine()
    {
        return $this->creatine;
    }

    /**
     * @param mixed $creatine
     * @return Consultation
     */
    public function setCreatine($creatine)
    {
        $this->creatine = $creatine;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUree()
    {
        return $this->uree;
    }

    /**
     * @param mixed $uree
     * @return Consultation
     */
    public function setUree($uree)
    {
        $this->uree = $uree;
        return $this;
    }

}
