<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;

class DashboardController extends AbstractController
{
  public function dashboard(Environment $twig)
  {

  	/* Redirige si non Logged*/
   	$securityContext = $this->container->get('security.authorization_checker');
  	if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
  	    return $this->redirectToRoute('security_login');		
  	}

    $user = $this->getUser();

    //Récupéraiton des projets de l'utilisateur
    $myProjects = self::getMyProjects($user->getId());

    $content = $twig->render("Dashboard/dashboard.html.twig", ['mesProjets' => $myProjects ]);

    return new Response($content);
  }

  /**
  * Récupération de la liste des projet d'un utilisateur
  * @param $userId  INT   Id de l'utilisateur connecté
  */
  public function getMyProjects($userId){

    return $this->getDoctrine()->getRepository('App\Entity\Projet')->findBy(array( 'fkOwner' => $userId));
  }

}