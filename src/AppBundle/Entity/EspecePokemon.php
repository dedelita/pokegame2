<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EspecePokemon
 *
 * @ORM\Table(name="espece_pokemon")
 * @ORM\Entity
 */
class EspecePokemon
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=11, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="courbe_XP", type="string", length=1, nullable=true)
     */
    private $courbeXp;

    /**
     * @var string
     *
     * @ORM\Column(name="evolution", type="string", length=1, nullable=true)
     */
    private $evolution;

    /**
     * @var string
     *
     * @ORM\Column(name="type1", type="string", length=8, nullable=true)
     */
    private $type1;

    /**
     * @var string
     *
     * @ORM\Column(name="type2", type="string", length=6, nullable=true)
     */
    private $type2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return EspecePokemon
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set courbeXp
     *
     * @param string $courbeXp
     *
     * @return EspecePokemon
     */
    public function setCourbeXp($courbeXp)
    {
        $this->courbeXp = $courbeXp;

        return $this;
    }

    /**
     * Get courbeXp
     *
     * @return string
     */
    public function getCourbeXp()
    {
        return $this->courbeXp;
    }

    /**
     * Set evolution
     *
     * @param string $evolution
     *
     * @return EspecePokemon
     */
    public function setEvolution($evolution)
    {
        $this->evolution = $evolution;

        return $this;
    }

    /**
     * Get evolution
     *
     * @return string
     */
    public function getEvolution()
    {
        return $this->evolution;
    }

    /**
     * Set type1
     *
     * @param string $type1
     *
     * @return EspecePokemon
     */
    public function setType1($type1)
    {
        $this->type1 = $type1;

        return $this;
    }

    /**
     * Get type1
     *
     * @return string
     */
    public function getType1()
    {
        return $this->type1;
    }

    /**
     * Set type2
     *
     * @param string $type2
     *
     * @return EspecePokemon
     */
    public function setType2($type2)
    {
        $this->type2 = $type2;

        return $this;
    }

    /**
     * Get type2
     *
     * @return string
     */
    public function getType2()
    {
        return $this->type2;
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
