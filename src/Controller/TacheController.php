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
  
  // Définition des constantes
  // TODO implémenter les autres valeurs modifiables
  const TACHE_LIBELLE   = 'libelle';
  const TACHE_USER      = 'fk_user_id';
  const TACHE_STATUT    = 'fk_statut_id';
  const TACHE_PRIORITE  = 'fk_priorite_id';
  const TACHE_DEADLINE  = 'deadline';

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
      $userTache      = $request->request->get('userTache') !== null ? $em->find( $this->getUser()->getId()) : null;
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
  }

  /**
   * Formatage de la deadline en Date pour Doctrine
   * @param STR $deadline   date de deadline de la tâche
   */
  public function formatDate($deadline){
    if($deadline === "")
      return null;
    $temp = explode('/', $deadline);
    return new \DateTime($temp[2].'-'.$temp[1].'-'.$temp[0]);
  }

  /**
   * Formatage de la deadline en Date pour Doctrine
   * @param STR $deadline   date de deadline de la tâche
   */
  public function formatDate2($deadline){
    if($deadline === "")
      return null;
    $temp = explode('=', $deadline);
    return new \DateTime($temp[2].'-'.$temp[1].'-'.$temp[0]);
  }



  /* ################################## Fonctions de modification de tache ##################################### */

  /**
   * @Route("/updateTache/{fieldToUpdate}-{tacheId}-{newValue}", name="update_tache")
   * Point d'entrée de la modification d'une tache, permet le routage vers la fonction concernée.
   * Fonction appelé via Ajax pour une modification en arrière plan
   * 
   * @param STR       $fieldToUpdate  Champ à modifier, utiliser les contantes de la classe
   * @param INT       $tacheId        id de la tâche a modifier
   * @param UNDEFINE  $newValue       Nouvelle valeur modificatrice
   */
  public function updateTache(Request $request, $fieldToUpdate, $tacheId, $newValue){

    switch($fieldToUpdate){
      case self::TACHE_STATUT :
        return $this->updateStatut($tacheId, $newValue);
        break;

      case self::TACHE_PRIORITE : 
        return $this->updatePriorite($tacheId, $newValue);
        break;

      case self::TACHE_LIBELLE :
        return $this->updateLibelle($tacheId, $newValue);
        break;

      case self::TACHE_DEADLINE :
        return $this->updateDeadline($tacheId, $newValue);
        break;
    }
  }

  /**
   * Modification du statut d'une tâche.
   * 
   * @param INT $tacheId  id de la tâche à modifier
   * @param INT $newValue id du nouveau statut
   * 
   */
  public function updateStatut($tacheId, $newValue){

    $em         = $this->getDoctrine()->getRepository('App\Entity\Statut');
    $statut      = $em->find($newValue);

    $em         = $this->getDoctrine()->getRepository('App\Entity\Tache');
    $tache      = $em->find($tacheId);

    $em = $this->getDoctrine()->getManager();
    $tache->setFkStatut($statut);
    $em->flush();

    return new Response('ok');

  }

  /**
   * Modification de la priorité d'une tâche.
   * 
   * @param INT $tacheId  id de la tâche à modifier
   * @param INT $newValue id de la nouvelle priorité
   * 
   */
  public function updatePriorite($tacheId, $newValue){

    $em         = $this->getDoctrine()->getRepository('App\Entity\Priorite');
    $priorite   = $em->find($newValue);

    $em         = $this->getDoctrine()->getRepository('App\Entity\Tache');
    $tache      = $em->find($tacheId);

    $em = $this->getDoctrine()->getManager();
    $tache->setFkPriorite($priorite);
    $em->flush();
    return new Response('ok');

  }

  /**
   * Modification du libellé d'une tâche.
   * 
   * @param INT $tacheId  id de la tâche à modifier
   * @param INT $newValue valeur du nouveau libellé
   * 
   */
  public function updateLibelle($tacheId, $newValue){

    $em         = $this->getDoctrine()->getRepository('App\Entity\Tache');
    $tache      = $em->find($tacheId);

    $em = $this->getDoctrine()->getManager();
    $tache->setLibelle($newValue);
    $em->flush();
    return new Response('ok');

  }

  /**
   * Modification de la deadline d'une tache
   * 
   * @param INT $tacheId  id de la tâche à modifier
   * @param INT $newValue valeur de la nouvelle deadline
   * 
   */
  public function updateDeadline($tacheId, $newValue){

    $em         = $this->getDoctrine()->getRepository('App\Entity\Tache');
    $tache      = $em->find($tacheId);

    $deadline       = self::formatDate2($newValue);

    $em = $this->getDoctrine()->getManager();
    $tache->setDeadline($deadline);
    $em->flush();
    return new Response('ok');

  }
}