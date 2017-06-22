<?php
namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class AnnoncesController extends Controller
{
    public function getAction(Request $request, EntityManagerInterface $em) {
        $dresseurRepository = $em->getRepository('AppBundle:Dresseur');

        $dresseur = $this->getUser();
        $idDresseur = $dresseur->getId();

        $annonces = $dresseurRepository->getAnnoncesForDresseur($idDresseur);
        $pokemons = $dresseurRepository->getPokemonsEnVente($idDresseur);

        return $this->render('annonces.html.twig', array("annonces" => $annonces, "pokemons" => $pokemons, "nbPieces" => $dresseur->getNbPieces()));
    }

    public function acheterPokemonAction(Request $request) {
        $idDresseur = $request->get('dresseur');

    }
}