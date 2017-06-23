<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PokemonRepository extends EntityRepository
{
    public function getInfosPokemon($id) {
        $pokemon = $this->find($id);

        $pok["id"] = $pokemon->getId();
        $pok["idDresseur"] = $pokemon->getIdDresseur();
        $pok["numero"] = $pokemon->getIdEspece();
        $pok["sexe"] = ($pokemon->getSexe() == "Male") ? "Male" : "Female";
        $pok["xp"] = $pokemon->getXp();
        $pok["niveau"] = $pokemon->getNiveau();
        $pok["prixVente"] = $pokemon->getPrixvente();
        $pok["enVente"] = $pokemon->getEnvente();
        $pok["dernierEntrainement"] = $pokemon->getDernierentrainement();
        $pok["timeToTrain"] = null;

        if(!$this->entrainementValide($pok["dernierEntrainement"], $pok["niveau"])) {
            $timeToTrain = strtotime($pokemon->getDernierEntrainement()) + 60 * 60;
            $pok["timeToTrain"] = round(abs($timeToTrain - time()) / 60);
        }

        $especePokemonRepository = $this->_em->getRepository('AppBundle:EspecePokemon');
        $especePokemon = $especePokemonRepository->find($pokemon->getIdEspece());

        $pok["types"] = array($especePokemon->getType1(), $especePokemon->getType2());
        $pok["nom"] = $especePokemon->getNom();
        if($especePokemon->getEvolution() == 'n')
            $pok["evolution"] = "Pokémon de base";
        else
            $pok["evolution"] = "Pokémon d'évolution";
        $pok["courbe_XP"] = $especePokemon->getCourbeXp();

        $pok["ceilxp"] = $this->maxXPForCurrentLevel($pok["courbe_XP"], $pokemon->getNiveau());

        return $pok;
    }

    public function newPokemon($idDresseur, $nom) {
        $espece = $this->findOneByNom($nom);

        $pokemon = new Pokemon();
        $pokemon->setIdDresseur($idDresseur);
        $pokemon->setNiveau(1);
        $pokemon->setXp(0);
        $pokemon->setSexe(intval(rand(0, 2)) ? 'Male' : 'Femelle');
        $pokemon->setEnvente(false);
        $pokemon->setIdEspece($espece->getId());

        $this->_em->persist($pokemon);
        $this->_em->flush();
    }

    public function entrainerPokemon($id) {
        $pokemon = $this->find($id);
        $espece = $this->_em->getRepository("AppBundle:EspecePokemon")->find($pokemon->getIdEspece());

        if($this->entrainementValide($pokemon->getDernierEntrainement(), $pokemon->getNiveau())) {
            $now = new \DateTime();

            $newxp = rand(10, 30);

            $pokemon->setXp($pokemon->getXp() + $newxp);
            $pokemon->setDernierEntrainement($now);
            $ceilxp = $this->maxXPForCurrentLevel($espece->getCourbeXp(), $pokemon->getNiveau());

            while($pokemon->getXp() >= $ceilxp) {
                $pokemon->setXp($pokemon->getXp() - $ceilxp);
                $pokemon->setNiveau($pokemon->getNiveau() + 1);

                $ceilxp = $this->maxXPForCurrentLevel($espece->getCourbeXp(), $pokemon->getNiveau());
            }

            $this->_em->persist($pokemon);
            $this->_em->flush();
        }
    }

    public function mettreEnVentePokemon($id, $prix) {
        $pokemon = $this->find($id);

        $pokemon->setEnVente(true);
        $pokemon->setPrixVente($prix);

        $this->_em->persist($pokemon);
        $this->_em->flush();
    }

    public function annulerVentePokemon($id) {
        $pokemon = $this->find($id);

        $pokemon->setEnVente(false);

        $this->_em->persist($pokemon);
        $this->_em->flush();
    }

    public function acheterPokemon($id, $idDresseur) {
        $pokemon = $this->find($id);

        $ancienDresseur = $this->_em->getRepository("AppBundle:Dresseur")->find($pokemon->getIdDresseur());
        $ancienDresseur->setNbPieces($ancienDresseur->getNbPieces() + $pokemon->getPrixVente());

        $nouveauDresseur = $this->_em->getRepository("AppBundle:Dresseur")->find($idDresseur);
        $nouveauDresseur->setNbPieces($nouveauDresseur->getNbPieces() - $pokemon->getPrixVente());

        $pokemon->setEnVente(false);
        $pokemon->setIdDresseur($idDresseur);

        $this->_em->persist($ancienDresseur);
        $this->_em->persist($nouveauDresseur);
        $this->_em->persist($pokemon);
        $this->_em->flush();
    }

    public function courbeXP_R($niveau) {
        return 0.8 * pow($niveau, 3);
    }

    public function courbeXP_M($niveau) {
        return pow($niveau, 3);
    }

    public function courbeXP_P($niveau) {
        return 1.2 * pow($niveau, 3) - 15 * pow($niveau, 2) + 100 * $niveau - 140;
    }

    public function courbeXP_L($niveau) {
        return 1.25 * pow($niveau, 3);
    }

    public function maxXPForCurrentLevel($courbeXP, $niveau) {
        $ceilOfCurrentLevel = 100;

        if($courbeXP == 'R') {
            $ceilOfCurrentLevel = $this->courbeXP_R($niveau);
        }

        else if($courbeXP == 'M') {
            $ceilOfCurrentLevel = $this->courbeXP_M($niveau);
        }

        else if($courbeXP == 'P') {
            $ceilOfCurrentLevel = $this->courbeXP_P($niveau);
        }

        else if($courbeXP == 'L') {
            $ceilOfCurrentLevel = $this->courbeXP_L($niveau);
        }

        return intval(max(1, $ceilOfCurrentLevel));
    }

    public function entrainementValide($dernierEntrainement, $niveau) {
        if(!$dernierEntrainement)
            return true;

        $diff = date_diff(new \DateTime($dernierEntrainement), new \DateTime());

        $h = $diff->h;

        if($h >= 1 && $niveau < 99)
            return true;

        return false;
    }
}