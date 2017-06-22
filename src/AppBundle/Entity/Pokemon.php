<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pokemon
 *
 * @ORM\Table(name="pokemon")
 * @ORM\Entity
 */
class Pokemon
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idDresseur", type="integer", nullable=false)
     */
    private $idDresseur;

    /**
     * @var integer
     *
     * @ORM\Column(name="idEspece", type="integer", nullable=false)
     */
    private $idEspece;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=7, nullable=false)
     */
    private $sexe;

    /**
     * @var integer
     *
     * @ORM\Column(name="XP", type="integer", nullable=false)
     */
    private $xp;

    /**
     * @var integer
     *
     * @ORM\Column(name="niveau", type="integer", nullable=false)
     */
    private $niveau = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="prixVente", type="integer", nullable=true)
     */
    private $prixvente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enVente", type="boolean", nullable=false)
     */
    private $envente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dernierEntrainement", type="datetime", nullable=true)
     */
    private $dernierentrainement;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set idDresseur
     *
     * @param integer $idDresseur
     *
     * @return Pokemon
     */
    public function setIdDresseur($idDresseur)
    {
        $this->iddresseur = $idDresseur;

        return $this;
    }

    /**
     * Get idDresseur
     *
     * @return integer
     */
    public function getIdDresseur()
    {
        return $this->idDresseur;
    }

    /**
     * Set idEspece
     *
     * @param integer $idEspece
     *
     * @return Pokemon
     */
    public function setIdEspece($idEspece)
    {
        $this->idEspece = $idEspece;

        return $this;
    }

    /**
     * Get idEspece
     *
     * @return integer
     */
    public function getIdEspece()
    {
        return $this->idEspece;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Pokemon
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set xp
     *
     * @param integer $xp
     *
     * @return Pokemon
     */
    public function setXp($xp)
    {
        $this->xp = $xp;

        return $this;
    }

    /**
     * Get xp
     *
     * @return integer
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set niveau
     *
     * @param integer $niveau
     *
     * @return Pokemon
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set prixvente
     *
     * @param integer $prixvente
     *
     * @return Pokemon
     */
    public function setPrixvente($prixvente)
    {
        $this->prixvente = $prixvente;

        return $this;
    }

    /**
     * Get prixvente
     *
     * @return integer
     */
    public function getPrixvente()
    {
        return $this->prixvente;
    }

    /**
     * Set envente
     *
     * @param boolean $envente
     *
     * @return Pokemon
     */
    public function setEnvente($envente)
    {
        $this->envente = $envente;

        return $this;
    }

    /**
     * Get envente
     *
     * @return boolean
     */
    public function getEnvente()
    {
        return $this->envente;
    }

    /**
     * Set dernierentrainement
     *
     * @param \DateTime $dernierentrainement
     *
     * @return Pokemon
     */
    public function setDernierentrainement($dernierentrainement)
    {
        $this->dernierentrainement = $dernierentrainement;

        return $this;
    }

    /**
     * Get dernierentrainement
     *
     * @return \DateTime
     */
    public function getDernierentrainement()
    {
        return $this->dernierentrainement;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
