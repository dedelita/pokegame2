<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dresseur
 *
 * @ORM\Table(name="dresseur")
 * @ORM\Entity
 */
class Dresseur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="nbPieces", type="integer", nullable=false)
     */
    private $nbpieces;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nbpieces
     *
     * @param integer $nbpieces
     *
     * @return Dresseur
     */
    public function setNbpieces($nbpieces)
    {
        $this->nbpieces = $nbpieces;

        return $this;
    }

    /**
     * Get nbpieces
     *
     * @return integer
     */
    public function getNbpieces()
    {
        return $this->nbpieces;
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
