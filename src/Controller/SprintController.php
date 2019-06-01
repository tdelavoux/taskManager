<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Tableau;
use App\Entity\Color;
use App\Entity\Sprint;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;


class SprintController extends AbstractController
{

  /* ################################## Fonctions de création de nouveau Sprint ########################### */

  /**
  * @Route("/addSprint", name="add_sprint")
  */
  public function addSprint(Request $request){

      // Récupétaion des information du formulaire et préparation de la requête
      $em = $this->getDoctrine()->getRepository('App\Entity\Tableau');
      $libelle      = $request->request->get('libelleSprint');
      $tableauId    = $request->request->get('fkTableau');
      $tableau      = $em->find($tableauId);
      $em = $this->getDoctrine()->getRepository('App\Entity\Color');
      $colorPattern = $request->request->get('colorHex');
      $color        = $em->findOneBy(array('hexa' => $colorPattern));

      if(self::verifyForm($libelle, $color)){
        //Création du nouveau sprint
        $em = $this->getDoctrine()->getManager();
        $sprint = new Sprint();
        $sprint->setLibelle($libelle);
        $sprint->setFkColor($color);
        $sprint->setFkTableau($tableau);

        $em->persist($sprint);
        $em->flush();

        $this->addFlash('success', 'Sprint créé avec succès ! '); /* TODO voir comment implémenter avec fetch pour affichage sur la page ? ==> MEssage correctement implémenté dans la page ? */

        exit();
      }


      $this->addFlash('danger', 'Libellé vide ou couleur incorecte ! '); /* TODO voir comment implémenter avec fetch pour affichage sur la page ? ==> MEssage correctement implémenté dans la page ? */

      exit();
  }

  /**
   * Vérification des champs saisis
   * 
   * @param STR     $libelle  libellé du strint
   * @param Color   $color    Couleur du sprint 
   */
  public function verifyForm($libelle, $color){

    if(trim($libelle) === ""){
      return false;
    }
    if($color === null){
      return false;
    }
    return true;  
  }


}