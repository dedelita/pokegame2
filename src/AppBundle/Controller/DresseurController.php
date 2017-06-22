<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 15/06/2017
 * Time: 15:46
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DresseurController extends Controller
{
    public function getPokemons($id) {
        $pokemonsRepository = $this->getDoctrine()->getRepository('AppBundle:Pokemon');
        $pokemons = $pokemonsRepository->findByIdDresseur($id);

        $especePokemonRepository = $this->getDoctrine()->getRepository('AppBundle:EspecePokemon');

        $poks = array();
        $pok = array();

        foreach ($pokemons as $pokemon) {
            $pok["id"] = $pokemon->getId();
            $pok["idDresseur"] = $pokemon->getIdDresseur();
            $pok["numero"] = $pokemon->getIdEspece();
            $pok["sexe"] = ($pokemon->getSexe() == "Male") ? "Male" : "Female";
            $pok["xp"] = $pokemon->getXp();
            $pok["niveau"] = $pokemon->getNiveau();
            $pok["prixVente"] = $pokemon->getPrixvente();
            $pok["enVente"] = $pokemon->getEnvente();
            $pok["dernierEntrainement"] = $pokemon->getDernierentrainement();

            $especePokemon = $especePokemonRepository->findById($pokemon->getIdEspece())[0];
            $pok["types"] = array($especePokemon->getType1(), $especePokemon->getType2());
            $pok["nom"] = $especePokemon->getNom();
            $pok["evolution"] = $especePokemon->getEvolution();
            $pok["courbe_XP"] = $especePokemon->getCourbeXp();

            $poks[] = $pok;
        }

        return $poks;
    }

    public function getPokemonsAction(Request $request) {
        $dresseur = $request->get("dresseur");

        $pokemons = $this->getPokemons($dresseur);

        return $this->render('pokemons.html.twig', array("dresseur" => $dresseur, "pokemons" => $pokemons));
    }

    public function getPokemonAction(Request $request) {
        $dresseur = $request->get("dresseur");
        $id = $request->get('id');

        $pokemonsRepository = $this->getDoctrine()->getRepository('AppBundle:Pokemon');
        $pokemon = $pokemonsRepository->find($id);

        $pok["id"] = $pokemon->getId();
        $pok["idDresseur"] = $pokemon->getIdDresseur();
        $pok["numero"] = $pokemon->getIdEspece();
        $pok["sexe"] = ($pokemon->getSexe() == "Male") ? "Male" : "Female";
        $pok["xp"] = $pokemon->getXp();
        $pok["niveau"] = $pokemon->getNiveau();
        $pok["prixVente"] = $pokemon->getPrixvente();
        $pok["enVente"] = $pokemon->getEnvente();
        $pok["dernierEntrainement"] = $pokemon->getDernierentrainement();

        $especePokemonRepository = $this->getDoctrine()->getRepository('AppBundle:EspecePokemon');
        $especePokemon = $especePokemonRepository->findById($pokemon->getIdEspece())[0];
        
        $pok["types"] = array($especePokemon->getType1(), $especePokemon->getType2());
        $pok["nom"] = $especePokemon->getNom();
        $pok["evolution"] = $especePokemon->getEvolution();
        $pok["courbe_XP"] = $especePokemon->getCourbeXp();

        return $this->render('pokemon.html.twig', array("pokemon" => $pok));
    }

    public function inscriptionAction(Request $request) {

        return $this->render("inscription.html.twig");
    }
}