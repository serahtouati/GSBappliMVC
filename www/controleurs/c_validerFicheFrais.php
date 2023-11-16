<?php
/**
 * Gestion de la connexion
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$mois = getMois(date('d/m/Y'));

switch ($action) {
    case 'selectionnerUtilisateur':
        $lesVisiteurs =$pdo->getNomVisiteur();
       // var_dump($lesVisiteurs);
            $lesCles = array_keys($lesVisiteurs);
        $visiteursASelectionner = $lesCles[0];
        //selection des mois
         $lesMois = getLesDouzeDerniersMois($mois);
        include 'vues/v_listeVisiteurs.php';
        break;
     case 'validerFicheFrais':
           $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
           $lesVisiteurs= $pdo->getNomVisiteur();
           $visiteurASelectionner= $idVisiteur;
           
           $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
           $lesMois = getLesDouzeDerniersMois($mois);
           $moisASelectionner= $leMois;
           
           $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
           $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
           //var_dump($lesFraisForfait, $lesFraisHorsForfait);
        if (empty($lesFraisForfait) && (empty($lesFraisHorsForfait)) ){
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
             include 'vues/v_erreurs.php';
             
                header("Refresh: 2;URL=index.php?uc=validerFicheFrais&action=selectionnerUtilisateur");
        } else {
            include 'vues/v_validerFicheFrais.php'; }

            break;
    case 'actualiseDonnees':
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs = $pdo->getNomVisiteur();
        $visiteurASelectionner = $idVisiteur;
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner = $leMois;

        var_dump($idVisiteur, $leMois, $lesFrais);
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        }
  include 'vues/v_validerFicheFrais.php';
                break;
           
}