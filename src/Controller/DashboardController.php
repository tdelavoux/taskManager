<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\User;

class DashboardController extends AbstractController
{
  public function dashboard(Environment $twig)
  {

  	/* Redirige si déjà Logged*/
   	$securityContext = $this->container->get('security.authorization_checker');
  	if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
  	    return $this->redirectToRoute('security_login');		
  	}

    $content = $twig->render("Dashboard/dashboard.html.twig");

    return new Response($content);
  }

}