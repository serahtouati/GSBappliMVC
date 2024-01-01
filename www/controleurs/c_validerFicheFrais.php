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
        $lesVisiteurs = $pdo->getNomVisiteur();
        // var_dump($lesVisiteurs);
        $lesCles = array_keys($lesVisiteurs);
        $visiteursASelectionner = $lesCles[0];
        //selection des mois
        $lesMois = getLesDouzeDerniersMois($mois);
        include 'vues/v_listeVisiteurs.php';
        break;
    case 'validerFicheFrais':
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs = $pdo->getNomVisiteur();
        $visiteurASelectionner = $idVisiteur;

        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner = $leMois;

        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        //var_dump($lesFraisForfait, $lesFraisHorsForfait);
        if (empty($lesFraisForfait) && (empty($lesFraisHorsForfait))) {
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';

            header("Refresh: 2;URL=index.php?uc=validerFicheFrais&action=selectionnerUtilisateur");
        } else {
            $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $mois);
            include 'vues/v_validerFicheFrais.php';
        }

        break;
    case 'majForfait':
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $lesVisiteurs = $pdo->getNomVisiteur();
        $visiteurASelectionner = $idVisiteur;
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = getLesDouzeDerniersMois($mois);
        $moisASelectionner = $leMois;

        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $leMois, $lesFrais);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
        }
        ajouterErreur('Les frais forfait ont bien été mis à jour.');
        include 'vues/v_erreurs.php';
       $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $mois);
        include 'vues/v_validerFicheFrais.php';
        break;


    case 'majHorsForfait':

        if (isset($_POST['corrigerFHF'])) {

            $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
            $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
            $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
            $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
            $unIdFrais = filter_input(INPUT_POST, 'unIdFrais', FILTER_SANITIZE_STRING);

            $lesVisiteurs = $pdo->getNomVisiteur();
            $visiteurASelectionner = $idVisiteur;

            $lesMois = getLesDouzeDerniersMois($mois);
            $moisASelectionner = $leMois;


            $pdo->majFraisHorsForfait($idVisiteur, $leMois, $libelle, $date, $montant, $unIdFrais);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);

            ajouterErreur('Le frais hors forfait a bien été mis à jour.');
            include 'vues/v_erreurs.php';

           $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $mois);
            include 'vues/v_validerFicheFrais.php';
        } elseif (isset($_POST['supprimerFHF'])) {

            $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
            $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
            $lesVisiteurs = $pdo->getNomVisiteur();
            $visiteurASelectionner = $idVisiteur;

            $lesMois = getLesDouzeDerniersMois($mois);
            $moisASelectionner = $leMois;
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);



            $unIdFrais = filter_input(INPUT_POST, 'unIdFrais', FILTER_SANITIZE_STRING);
            $pdo->supprimerFraisHorsForfait($unIdFrais);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
            ajouterErreur('Le frais hors forfait a bien été supprimé.');
            include 'vues/v_erreurs.php';
           $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $mois);
            include 'vues/v_validerFicheFrais.php';
            
        } elseif (isset($_POST['reporterFHF'])) {
            // echo "coucou";
            $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
            $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
            $lesVisiteurs = $pdo->getNomVisiteur();
            $visiteurASelectionner = $idVisiteur;

            $lesMois = getLesDouzeDerniersMois($mois);
            $moisASelectionner = $leMois;
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);


            $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
            $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
            $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
            $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
            $unIdFrais = filter_input(INPUT_POST, 'unIdFrais', FILTER_SANITIZE_STRING);

            $libelle2 = "REFUSER " . $libelle;
            $pdo->majFraisHorsForfait($idVisiteur, $leMois, $libelle2, $date, $montant, $unIdFrais);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);

            $moisSuivant = getMoisSuivant($leMois);
            $pdo->creeNouveauFraisHorsForfait($idVisiteur, $moisSuivant, $libelle, $date, $montant, $unIdFrais);


            ajouterErreur('Le frais hors forfait a bien été repporté.');
            include 'vues/v_erreurs.php';
            
           $nbJustificatifs= $pdo->getNbjustificatifs($idVisiteur, $mois);
            include 'vues/v_validerFicheFrais.php';
            
        }

        break;
}