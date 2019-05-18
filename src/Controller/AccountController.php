<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



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

  /**
  * @Route("/modifyAccount", name="security_account")
  */
  public function modifyAccount(Request $request){


    $em = $this->getDoctrine()->getManager();
    $user = $this->getUser();

   
    $username = $request->request->get('_username');
    $email = $request->request->get('_email');

    $this->verifyForm($user, $username, $email);

    $user->setUsername($username);
    $user->setEmail($email);
    $em->flush();

    return $this->redirectToRoute('account');   
  }

  /**
  * @Route("/modifyPasswd", name="security_account_passwd")
  */
  public function modifyPasswd(Request $request){

    $encoder = new \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder(13);
    $em = $this->getDoctrine()->getManager();
    $user = $this->getUser();

    //$encoder = $this->encoderFactory->getEncoder($user);

    $oldPasswd = $request->request->get('_oldPasswd');
    $newPasswd = $request->request->get('_newPasswd');


    if($encoder->isPasswordValid($user->getPassword(), $oldPasswd, $user->getSalt()) && $newPasswd !== self::EMPTY_STRING){
      $user->setPasswd($encoder->encodePassword($user, $newPasswd));
      $em->flush();

      return $this->redirectToRoute('account');
    }


    

    return $this->redirectToRoute('account');
  }


  /**
  * Vérification de la validité du formulaire de modification
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