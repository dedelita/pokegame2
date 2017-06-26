<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 15/06/2017
 * Time: 15:46
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Dresseur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\FormError;

class DresseurController extends Controller
{
    public function getPokemons($id) {
        $pokemonsRepository = $this->getDoctrine()->getRepository('AppBundle:Pokemon');
        $pokemons = $pokemonsRepository->findByIdDresseur($id);

        $poks = array();
        foreach ($pokemons as $pokemon) {
            $poks[] = $pokemonsRepository->getInfosPokemon($pokemon->getId());
        }

        return $poks;
    }

    public function getPokemonsAction(Request $request) {
        $dresseur = $this->getUser();
        $id = $dresseur->getId();
        $pokemons = $this->getPokemons($id);
        
        return $this->render('pokemons.html.twig', array("dresseur" => $dresseur, "pokemons" => $pokemons));
    }

    public function getPokemonAction($id) {
        //$id = $request->get('id');

        $pokemonsRepository = $this->getDoctrine()->getRepository('AppBundle:Pokemon');
        $pokemon = $pokemonsRepository->getInfosPokemon($id);

        return $this->render('pokemon.html.twig', array("pokemon" => $pokemon, "form" => null));
    }

    public function loginAction(Request $request, AuthenticationUtils $authUtils) {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function inscriptionAction(Request $request) {
        $dresseur = new Dresseur();
        $form = $this->createFormBuilder($dresseur)
            ->add("login", TextType::class, array("label" => "Nom"))
            ->add("email", EmailType::class, array("label" => "Mail"))
            ->add("password", PasswordType::class, array("label" => "Mot de passe"))
            ->add("conf_password", PasswordType::class, array("label" => "Confirmer", "mapped" => false))
            ->add("pokemon", ChoiceType::class, array("label" => "Votre 1er pokémon",
                'choices' => array("Bulbizarre" => "Bulbizarre", "Carapuce" => "Carapuce", "Salamèche" => "Salamèche"), "mapped" => false))
            ->add("submit", SubmitType::class, array("label" => "Go"))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dre = $em->getRepository("AppBundle:Dresseur")->findOneByEmail($dresseur->getEmail());
            if($dre)
                $form->addError(new FormError('Mail déjà utilisé'));

            $dre = $em->getRepository("AppBundle:Dresseur")->findOneByLogin($dresseur->getLogin());
            if($dre)
                $form->addError(new FormError('Nom déjà utilisé'));

            else {
                if($form->get("password")->getData() == $form->get("conf_password")->getData()) {
                    $dresseur->setNbPieces(5000);

                    $em->persist($dresseur);
                    $em->flush();

                    $dre = $em->getRepository("AppBundle:Dresseur")->findOneByEmail($dresseur->getEmail());

                    $em->getRepository("AppBundle:Pokemon")->newPokemon($dre->getId(), $form->get("pokemon")->getData());
                } else {
                    $form->addError(new FormError('Les mots de passe ne correspondent pas'));
                }
            }
            return $this->redirectToRoute("connexion");
        } else
            return $this->render("inscription.html.twig", array('form' => $form->createView()));
    }

    public function entrainerPokemonAction(Request $request) {
        $id = $request->get('id');

        $this->getDoctrine()->getRepository("AppBundle:Pokemon")->entrainerPokemon($id);

        return $this->redirectToRoute('pokemon', array("id" => $id, "form" => null));
    }

    public function mettreEnVentePokemonAction(Request $request) {
        $id = $request->get('id');
        $pokemonRepository = $this->getDoctrine()->getRepository("AppBundle:Pokemon");
        $pokemon = $pokemonRepository->find($id);

        $form = $this->createFormBuilder()
            ->add("prix", TextType::class, array("label" => "Prix de vente", "data" => $pokemon->getPrixVente()))
            ->add("submit", SubmitType::class, array("label" => "Mettre en vente"))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $pokemonRepository->mettreEnVentePokemon($id, $form->get("prix")->getData());
            return $this->redirectToRoute("pokemon", array("id" => $id, "form" => null));
        }
        return $this->render('pokemon.html.twig', array("id" => $id, "pokemon" => $pokemonRepository->getInfosPokemon($id), "form" => $form->createView()));
    }

    public function annulerVentePokemonAction(Request $request) {
        $id = $request->get('id');

        $this->getDoctrine()->getRepository("AppBundle:Pokemon")->annulerVentePokemon($id);

        if($request->get('_route') == "pokemon")
            return $this->redirectToRoute('pokemon', array("id" => $id, "form" => null));
        else
            return $this->redirectToRoute('annonces');
    }

    public function acheterPokemonAction(Request $request) {
        $id = $request->get('id');
        $idDresseur = $this->getUser()->getId();

        $pokemonRepository = $this->getDoctrine()->getRepository("AppBundle:Pokemon");
        $pokemonRepository->acheterPokemon($id, $idDresseur);

        return $this->redirectToRoute('annonces');
    }

    public function jsonPokemonsAction(Request $request) {
        $especePokemonsRepository = $this->getDoctrine()->getRepository("AppBundle:EspecePokemon");

        $dresseur = $request->query->get('dresseur');
        if($dresseur)
            return $this->jsonPokemonsOfDresseurAction($request);

        $pokemons = $especePokemonsRepository->findAll();
        $poks = array();
        $pok = array();

        foreach ($pokemons as $p) {
            $pok["id"] = $p->getId();
            $pok["nom"] = $p->getNom();
            $pok["courbeXp"] = $p->getCourbeXp();
            $pok["evolution"] = $p->getEvolution();
            $pok["type1"] = $p->getType1();
            $pok["type2"] = $p->getType2();

            $poks[] = $pok;
        }

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->setContent(json_encode($poks));
        $response->setCharset("utf-8");

        return $response;
    }

    public function jsonPokemonAction($id) {
        $pokemonsRepository = $this->getDoctrine()->getRepository("AppBundle:Pokemon");
        $pokemon = $pokemonsRepository->find($id);

        $especePokemonsRepository = $this->getDoctrine()->getRepository("AppBundle:EspecePokemon");
        $espece = $especePokemonsRepository->find($pokemon->getIdEspece());

        $pok = array();
        $pok["id"] = $pokemon->getId();
        $pok["idDresseur"] = $pokemon->getIdDresseur();
        $pok["idEspece"] = $espece->getId();
        $pok["nom"] = $espece->getNom();
        $pok["courbeXp"] = $espece->getCourbeXp();
        $pok["evolution"] = $espece->getEvolution();
        $pok["type1"] = $espece->getType1();
        $pok["type2"] = $espece->getType2();
        $pok["niveau"] = $pokemon->getNiveau();
        $pok["sexe"] = $pokemon->getSexe();
        $pok["xp"] = $pokemon->getXp();
        $pok["enVente"] = $pokemon->getEnVente();
        $pok["prixVente"] = $pokemon->getPrixVente();
        $pok["dernierEntrainement"] = $pokemon->getDernierEntrainement();

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->setContent(json_encode($pok, JSON_PRETTY_PRINT));
        $response->setCharset("utf-8");

        return $response;
    }

    public function jsonPokemonsOfDresseurAction($id) {
        $pokemonsRepository = $this->getDoctrine()->getRepository("AppBundle:Pokemon");
        $pokemons = $pokemonsRepository->findByIdDresseur($id);

        $especePokemonsRepository = $this->getDoctrine()->getRepository("AppBundle:EspecePokemon");

        $poks = array();
        $pok = array();

        foreach ($pokemons as $p) {
            $espece = $especePokemonsRepository->find($p->getIdEspece());

            $pok["id"] = $p->getId();
            $pok["idDresseur"] = $p->getIdDresseur();
            $pok["idEspece"] = $espece->getId();
            $pok["nom"] = $espece->getNom();
            $pok["courbeXp"] = $espece->getCourbeXp();
            $pok["evolution"] = $espece->getEvolution();
            $pok["type1"] = $espece->getType1();
            $pok["type2"] = $espece->getType2();
            $pok["niveau"] = $p->getNiveau();
            $pok["sexe"] = $p->getSexe();
            $pok["xp"] = $p->getXp();
            $pok["enVente"] = $p->getEnVente();
            $pok["prixVente"] = $p->getPrixVente();
            $pok["dernierEntrainement"] = $p->getDernierEntrainement();

            $poks[] = $pok;
        }

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->setContent(json_encode($poks, JSON_PRETTY_PRINT));
        $response->setCharset("utf-8");

        return $response;
    }
}