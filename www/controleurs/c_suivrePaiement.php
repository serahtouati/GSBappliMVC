<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
$leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);

$lesVisiteurs = $pdo->getNomVisiteurVA();

$visiteurASelectionner = $idVisiteur;
$moisASelectionner = $leMois;
$mois = getMois(date('d/m/Y'));
$lesMois = $pdo-> getLesMoisDisponiblesVA();
//var_dump($lesMois);

switch ($action) {
    case 'selectionnerUtilisateur':
        $lesCles[] = array_keys($lesVisiteurs);
        $visiteursASelectionner = $lesCles[0];
        include 'vues/v_visiteurVA.php';
        break;       
    
  case 'valider':
      echo 'coucou';
          $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
    $moisASelectionner = $leMois;
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_suivrePaiement.php';
        break;
}