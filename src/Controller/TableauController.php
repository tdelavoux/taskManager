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

  /* ################################## Fonctions de création et modification de nouveau tableau ########################### */

  /**
  * @Route("/addTable", name="add_table")
  */
  public function addTable(Request $request){

      // Récupétaion des information du formulaire et préparation de la requête
      $em       = $this->getDoctrine()->getRepository('App\Entity\Projet');
      $libelle  = $request->request->get('libelleTableau');
      $projetId = $request->request->get('fkProjet');
      $projet   = $em->find($projetId);

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

  /**
   * @Route("/deleteTableau/{idTableau}", name="delete_tableau")
   */
   public function deleteTableau(Request $request, $idTableau){

      /* ToDo suppression totale des taches, sprint puis du tableau */
      $em       = $this->getDoctrine()->getRepository('App\Entity\Tableau');
      $tableau  = $em->find($idTableau);

      $em = $this->getDoctrine()->getManager();

      foreach($tableau->getSprints() as $sprint){
        foreach($sprint->getTaches() as $tache){
          $em->remove($tache);
        }
        $em->remove($sprint);
      }
      $em->remove($tableau);
      $em->flush();

      $this->addFlash('success', 'Tableau supprimé avec succès ! ');

      return $this->redirectToRoute('dashboard');
   }

  /* ################################## Affichage projet ########################################################## */

  /**
  * @Route("/viewTableau/{idTableau}", name="view_tableau")
  */
  public function viewTableau(Environment $twig, $idTableau){

    $em         = $this->getDoctrine()->getRepository('App\Entity\Tableau');
    $tableau    = $em->find($idTableau);

    $em         = $this->getDoctrine()->getRepository('App\Entity\Projet');
    $projet     = $em->find($tableau->getFkProjet());

    $sprints    = $tableau->getSprints();

    $em         = $this->getDoctrine()->getRepository('App\Entity\Color');
    $colors     = $em->findBy(array());

    $em         = $this->getDoctrine()->getRepository('App\Entity\Statut');
    $status     = $em->findBy(array());

    $em         = $this->getDoctrine()->getRepository('App\Entity\Priorite');
    $priorities = $em->findBy(array());

    $content    = $twig->render("Tableau/viewTableau.html.twig", [ 'tableau' => $tableau, 'projet' => $projet, 'sprints' => $sprints, 'colors' => $colors, 'status' => $status, 'priorities' => $priorities ]);

    return new Response($content);
  }

}