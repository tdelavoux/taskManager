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
use Doctrine\ORM\Mapping as ORM;


class TableauController extends AbstractController
{

  /* ################################## Fonctions de création de nouveau tableau ########################### */

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

      $this->addFlash('success', 'Tableau créé avec succès ! '); /* TODO voir comment implémenter avec fetch pour affichage sur la page ? ==> MEssage correctement implémenté dans la page ? */

      exit();
  }

  /* ################################## Affichage projet ########################### */

  /**
  * @Route("/viewTableau/{idTableau}", name="view_tableau")
  */
  public function viewTableau(Environment $twig, $idTableau){

    $em = $this->getDoctrine()->getRepository('App\Entity\Tableau');
    $tableau = $em->find($idTableau);

    $em = $this->getDoctrine()->getRepository('App\Entity\Projet');
    $projet = $em->find($tableau->getFkProjet());

    $sprints = $tableau->getSprints();

    $em = $this->getDoctrine()->getRepository('App\Entity\Color');
    $colors = $em->findBy(array());

    $content = $twig->render("Tableau/viewTableau.html.twig", [ 'tableau' => $tableau, 'projet' => $projet, 'sprints' => $sprints, 'colors' => $colors ]);

    return new Response($content);
  }

}