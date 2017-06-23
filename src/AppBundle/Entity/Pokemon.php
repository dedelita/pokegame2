<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pokemon
 *
 * @ORM\Table(name="pokemon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PokemonRepository")
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
    private $prixVente;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enVente", type="boolean", nullable=false)
     */
    private $enVente;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dernierEntrainement", type="datetime", nullable=true)
     */
    private $dernierEntrainement;

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
        $this->idDresseur = $idDresseur;

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
     * Set prixVente
     *
     * @param integer $prixVente
     *
     * @return Pokemon
     */
    public function setPrixvente($prixVente)
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    /**
     * Get prixVente
     *
     * @return integer
     */
    public function getPrixvente()
    {
        return $this->prixVente;
    }

    /**
     * Set enVente
     *
     * @param boolean $enVente
     *
     * @return Pokemon
     */
    public function setEnvente($enVente)
    {
        $this->enVente = $enVente;

        return $this;
    }

    /**
     * Get enVente
     *
     * @return boolean
     */
    public function getEnvente()
    {
        return $this->enVente;
    }

    /**
     * Set dernierEntrainement
     *
     * @param \DateTime $dernierEntrainement
     *
     * @return Pokemon
     */
    public function setDernierentrainement($dernierEntrainement)
    {
        $this->dernierEntrainement = $dernierEntrainement;

        return $this;
    }

    /**
     * Get dernierEntrainement
     *
     * @return \DateTime
     */
    public function getDernierentrainement()
    {
        if(!$this->dernierEntrainement)
            return null;
        
        return $this->dernierEntrainement->format("Y-m-d H:i:s");
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
