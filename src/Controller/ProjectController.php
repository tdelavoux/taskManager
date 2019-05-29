<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Projet;
use App\Entity\Tableau;

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
  * @Route("/addProjet", name="create_projet")
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

  /**
  * @Route("/viewProjet/{idProjet}", name="view_projet")
  */
  public function viewProjet(Environment $twig, $idProjet){

    $em = $this->getDoctrine()->getRepository('App\Entity\Projet');
    $user = $this->getUser();

    $projet = $em->find($idProjet);

    /* TODO Peupler la page*/

    $content = $twig->render("Project/viewProject.html.twig", [ 'projet' => $projet ]);

    return new Response($content);
  }

  /**
  * @Route("/addTable", name="add_table")
  */
  public function addTable(Request $request){

      // Récupétaion des information du formulaire et préparation de la requête
      $em = $this->getDoctrine()->getRepository('App\Entity\Projet');
      $libelle = $request->request->get('libelleTableau');
      $projetId = $request->request->get('fkProjet');
      $projet = $em->find($projetId);

      $em = $this->getDoctrine()->getManager();

      //Création du nouveau tableau
      $tableau = new Tableau();
      $tableau->setLibelle($libelle);
      $tableau->setFkProjet($projet);
      $em->persist($tableau);
      $em->flush();

      $this->addFlash('success', 'Tableau créé avec succès ! ');

      exit();
  }

}