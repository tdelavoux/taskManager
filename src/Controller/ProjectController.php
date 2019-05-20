<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Projet;

use App\Entity\User;

class ProjectController extends AbstractController
{

  /* ################################## Fonctions de création de nouveau projet ########################### */

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


  /**
  * @Route("/addProjet", name="create_projet"))
  */
  public function addProjet(Request $request){

    $em = $this->getDoctrine()->getManager();
    $user = $this->getUser();

    $libelle = $request->request->get('projetName');

    $project = new Projet();

    $project->setLibelle($libelle);
    $project->setFkOwner($user);
    $em->persist($project);
    $em->flush();

    $this->addFlash('success', 'Projet créé avec succès ! ');

    return $this->redirectToRoute('dashboard');
  }

  /* ################################## Affichage projet ########################### */

}