<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AccountController extends AbstractController
{

  const EMPTY_STRING = "";

  public function account(Environment $twig)
  {

  	/* Redirige si déjà Logged*/
   	$securityContext = $this->container->get('security.authorization_checker');
  	if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
        return $this->redirectToRoute('security_login');    
    }


    $user = $this->getUser();

    $content = $twig->render("Account/account.html.twig", ['name' => $user->getUsername(), 'email' => $user->getEmail() ]);

    return new Response($content);
  }


  /* ################################## Fonctions de modification ########################### */

  /**
  * Fonction traitant la modification des informations personnelles
  *
  * @Route("/modifyAccount", name="security_account")
  */
  public function modifyAccount(Environment $twig, Request $request){


    $em = $this->getDoctrine()->getManager();
    $user = $this->getUser();

    $username = $request->request->get('username');
    $email = $request->request->get('email');

    $this->verifyForm($user, $username, $email);

    $user->setUsername($username);
    $user->setEmail($email);
    $em->flush();

    $this->addFlash('success', 'Informations modifiées avec succès ! ');

    $content = $twig->render("Account/account.html.twig", ['name' => $user->getUsername(), 'email' => $user->getEmail()]);

    return new Response($content);
  }


  /**
  * Modification du Mot de Passe de Login Utilsiateur à l'envoie du formulaire 
  *
  * @Route("/modifyPasswd", name="security_account_passwd")
  */
  public function modifyPasswd(Environment $twig, Request $request, UserPasswordEncoderInterface $encoder){

    $encoderComparator = new \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder(13);
    $em = $this->getDoctrine()->getManager();
    $user = $this->getUser();

    $oldPasswd = $request->request->get('oldPasswd');
    $newPasswd = $request->request->get('newPasswd');

    if($encoderComparator->isPasswordValid($user->getPassword(), $oldPasswd, $user->getSalt()) && $newPasswd !== self::EMPTY_STRING){
      $hash = $encoder->encodePassword($user, $newPasswd);
      $user->setPasswd($hash);
      $em->flush();

      $this->addFlash('success', 'Changement du mot de passe réalisé avec succès ! ');

      $content = $twig->render("Account/account.html.twig", ['name' => $user->getUsername(), 'email' => $user->getEmail()]);

      return new Response($content);
    }
    
    $this->addFlash('danger', 'Erreur lors de la saisie de l\'ancien mot de passe ');
    $content = $twig->render("Account/account.html.twig", ['name' => $user->getUsername(), 'email' => $user->getEmail()]);

    return new Response($content);
  }


  /**
  * Vérification de la validité du formulaire de modification
  * @param $user       USER     Instance de l'utilisateur connecté
  * @param $username   STR      Nom saisis par l'utilisateur
  * @param $email      SRT      Adresse email à vérifier
  *
  */
  public static function verifyForm($user, $username, $email){

    $valid = true;

    if($username === self::EMPTY_STRING){
      $valid = false; 
    }

    if($email === self::EMPTY_STRING){
      $valid = false;
    }

    if(!$user->isEmailValid($email)){
      $valid = false;
    }

    return $valid;
  }


}