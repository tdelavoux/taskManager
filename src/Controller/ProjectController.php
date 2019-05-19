<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

class ProjectController extends AbstractController
{

  /**
  * @Route("/newProjet", name="add_Projet")
  */
  public function newProjet(Environment $twig)
  {

  	/* Redirige si non Logged*/
   	$securityContext = $this->container->get('security.authorization_checker');
  	if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
  	    return $this->redirectToRoute('security_login');		
  	}

    $user = $this->getUser();

    $content = $twig->render("Project/addProject.html.twig");

    return new Response($content);
  }

}