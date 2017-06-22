<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        var_dump($request->getSession());
        return $this->render('default/index.html.twig');
    }

    public function connexionAction(Request $request)
    {
        $login = $request->get("login");

        if(!$login)
            $error = NULL;
        else {
            $userRepository = $this->getDoctrine()->getRepository('AppBundle:User');
            $user = $userRepository->findByLogin($login);

            if(!$user)
                $error = "Cet utilisateur n'existe pas";
            else {
                $user = $user[0];
                $password = $request->get("password");

                if($user->getPassword() == sha1($password))
                    return $this->redirect($this->generateUrl('pokemons', array("dresseur" => $user->getId())));
                else
                    $error = "Le mot de passe est incorrect";
            }
        }

        return $this->render('login.html.twig', array("error" => $error));
    }
/*
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
*/
}
