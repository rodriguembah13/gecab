<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
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
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $civilite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $situationfamiliale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profession;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $groupsanguin;
    /**
     * @ORM\Column(type="float", length=255, nullable=true)
     */
    private $poids;
    /**
     * @ORM\Column(type="float", length=255, nullable=true)
     */
    private $taille;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomgarde;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pin;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $relactiongarde;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adressegarde;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $villegarde;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regiongarde;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pingarde;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paysgarde;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephonegarde;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;
    /**
     * @ORM\OneToMany(targetEntity=AntecedantPatient::class, mappedBy="patient")
     */
    private $antecedantPatients;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="patient")
     */
    private $factures;

    /**
     * @ORM\OneToMany(targetEntity=Hospitalisation::class, mappedBy="patient")
     */
    private $hospitalisations;

    /**
     * @ORM\ManyToOne(targetEntity=Clinique::class, inversedBy="patients")
     */
    private $clinique;

    /**
     * @ORM\ManyToOne(targetEntity=FamillePatient::class, inversedBy="patients")
     */
    private $famille;

    public function __construct()
    {
        $this->antecedantPatients = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->hospitalisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getSituationfamiliale(): ?string
    {
        return $this->situationfamiliale;
    }

    public function setSituationfamiliale(?string $situationfamiliale): self
    {
        $this->situationfamiliale = $situationfamiliale;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroupsanguin()
    {
        return $this->groupsanguin;
    }

    /**
     * @param mixed $groupsanguin
     * @return Patient
     */
    public function setGroupsanguin($groupsanguin)
    {
        $this->groupsanguin = $groupsanguin;
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
     * @return Patient
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
     * @return Patient
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomgarde()
    {
        return $this->nomgarde;
    }

    /**
     * @param mixed $nomgarde
     * @return Patient
     */
    public function setNomgarde($nomgarde)
    {
        $this->nomgarde = $nomgarde;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     * @return Patient
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @param mixed $pin
     * @return Patient
     */
    public function setPin($pin)
    {
        $this->pin = $pin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     * @return Patient
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelactiongarde()
    {
        return $this->relactiongarde;
    }

    /**
     * @param mixed $relactiongarde
     * @return Patient
     */
    public function setRelactiongarde($relactiongarde)
    {
        $this->relactiongarde = $relactiongarde;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdressegarde()
    {
        return $this->adressegarde;
    }

    /**
     * @param mixed $adressegarde
     * @return Patient
     */
    public function setAdressegarde($adressegarde)
    {
        $this->adressegarde = $adressegarde;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVillegarde()
    {
        return $this->villegarde;
    }

    /**
     * @param mixed $villegarde
     * @return Patient
     */
    public function setVillegarde($villegarde)
    {
        $this->villegarde = $villegarde;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegiongarde()
    {
        return $this->regiongarde;
    }

    /**
     * @param mixed $regiongarde
     * @return Patient
     */
    public function setRegiongarde($regiongarde)
    {
        $this->regiongarde = $regiongarde;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPingarde()
    {
        return $this->pingarde;
    }

    /**
     * @param mixed $pingarde
     * @return Patient
     */
    public function setPingarde($pingarde)
    {
        $this->pingarde = $pingarde;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaysgarde()
    {
        return $this->paysgarde;
    }

    /**
     * @param mixed $paysgarde
     * @return Patient
     */
    public function setPaysgarde($paysgarde)
    {
        $this->paysgarde = $paysgarde;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelephonegarde()
    {
        return $this->telephonegarde;
    }

    /**
     * @param mixed $telephonegarde
     * @return Patient
     */
    public function setTelephonegarde($telephonegarde)
    {
        $this->telephonegarde = $telephonegarde;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     * @return Patient
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    public function __toString()
    {
       return $this->nomComplet;
    }

    public function calulAge(){
        $age= date_diff($this->dateNaissance,new \DateTime('now'))->y;
        return $age;
    }

    /**
     * @return Collection|AntecedantPatient[]
     */
    public function getAntecedantPatients(): Collection
    {
        return $this->antecedantPatients;
    }

    public function addAntecedantPatient(AntecedantPatient $antecedantPatient): self
    {
        if (!$this->antecedantPatients->contains($antecedantPatient)) {
            $this->antecedantPatients[] = $antecedantPatient;
            $antecedantPatient->setPatient($this);
        }

        return $this;
    }

    public function removeAntecedantPatient(AntecedantPatient $antecedantPatient): self
    {
        if ($this->antecedantPatients->removeElement($antecedantPatient)) {
            // set the owning side to null (unless already changed)
            if ($antecedantPatient->getPatient() === $this) {
                $antecedantPatient->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setPatient($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getPatient() === $this) {
                $facture->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Hospitalisation[]
     */
    public function getHospitalisations(): Collection
    {
        return $this->hospitalisations;
    }

    public function addHospitalisation(Hospitalisation $hospitalisation): self
    {
        if (!$this->hospitalisations->contains($hospitalisation)) {
            $this->hospitalisations[] = $hospitalisation;
            $hospitalisation->setPatient($this);
        }

        return $this;
    }

    public function removeHospitalisation(Hospitalisation $hospitalisation): self
    {
        if ($this->hospitalisations->removeElement($hospitalisation)) {
            // set the owning side to null (unless already changed)
            if ($hospitalisation->getPatient() === $this) {
                $hospitalisation->setPatient(null);
            }
        }

        return $this;
    }

    public function getClinique(): ?Clinique
    {
        return $this->clinique;
    }

    public function setClinique(?Clinique $clinique): self
    {
        $this->clinique = $clinique;

        return $this;
    }

    public function getFamille(): ?FamillePatient
    {
        return $this->famille;
    }

    public function setFamille(?FamillePatient $famille): self
    {
        $this->famille = $famille;

        return $this;
    }
}
