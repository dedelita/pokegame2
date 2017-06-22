<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DresseurRepository extends EntityRepository
{
    public function getAnnoncesForDresseur($id) {
        $query = $this->_em->createQuery('SELECT p.id, p.idDresseur, p.idEspece, p.sexe, p.xp, p.niveau, p.prixVente,
            p.dernierEntrainement, e.nom FROM AppBundle:Pokemon p, AppBundle:EspecePokemon e 
            WHERE p.idDresseur != :id AND p.enVente = true AND p.idEspece = e.id');
        $query->setParameter('id', $id);
        return $query->getResult();
    }

    public function getPokemonsEnVente($id) {
        $query = $this->_em->createQuery('SELECT  p.id, p.idDresseur, p.idEspece, p.sexe, p.xp, p.niveau, p.prixVente,
            p.dernierEntrainement, e.nom FROM AppBundle:Pokemon p, AppBundle:EspecePokemon e 
            WHERE p.idDresseur = :id AND p.enVente = true AND p.idEspece = e.id');
        $query->setParameter('id', $id);

        return $query->getResult();
    }
}