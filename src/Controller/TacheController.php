<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Color;
use App\Entity\Sprint;
use App\Entity\Tache;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;


class TacheController extends AbstractController
{

  /* ################################## Fonctions de création de nouvelle tache ########################### */

  /**
  * @Route("/addTache", name="add_tache")
  */
  public function addTache(Request $request){

      // Récupétaion des information du formulaire et préparation de la requête
      $libelle        = $request->request->get('libelleTache');
      $em             = $this->getDoctrine()->getRepository('App\Entity\Sprint');
      $sprintid       = $request->request->get('fkSprint');
      $sprint         = $em->find($sprintid);
      $deadline       = self::formatDate($request->request->get('deadline'));
      $commentTache   = $request->request->get('commentTache');
      $em             = $this->getDoctrine()->getRepository('App\Entity\User');
      $userTache      = $request->request->get('userTache') ?  $em->find($this->getUser()->getId()) : null;
      $em             = $this->getDoctrine()->getRepository('App\Entity\Statut');
      $statut         = $em->find(1);
      $em             = $this->getDoctrine()->getRepository('App\Entity\Priorite');
      $priorite       = $em->find(1);

      if(self::verifyForm($libelle)){
        
        $em = $this->getDoctrine()->getManager();
        $tache = new Tache();
        $tache->setLibelle($libelle);
        $tache->setFkSprint($sprint);
        $tache->setDeadline($deadline);
        $tache->setCommentaire($commentTache);
        $tache->setFkUser($userTache);
        $tache->setFkStatut($statut);
        $tache->setFkPriorite($priorite);
        $em->persist($tache);
        $em->flush();

        $this->addFlash('success', 'Tâche créé avec succès ! '); 

        exit();
      }


      $this->addFlash('danger', 'Tâche incorecte ! ');

      exit();
  }

  /**
   * Vérification des champs saisis
   * 
   * @param STR $libelle  Libellé de la tâche
   */
  public function verifyForm($libelle){
    return trim($libelle) === "" ? false : true;
    /* TODO cérification du bon format de la date*/
  }

  /**
   * Formatage de la deadline en Date pour Doctrine
   * @param STR $deadline   date de deadline de la tâche
   */
  public function formatDate($deadline){
    if($deadline === "")
      return null;
    $temp = explode('/', $deadline);
    return new \DateTime($temp[2].'-'.$temp[0].'-'.$temp[1]);
  }


}