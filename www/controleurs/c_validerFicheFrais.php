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
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
$leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
$libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
$montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
$unIdFrais = filter_input(INPUT_POST, 'unIdFrais', FILTER_SANITIZE_STRING);
$lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
$lesVisiteurs = $pdo->getNomVisiteur();
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
$visiteurASelectionner = $idVisiteur;
$moisASelectionner = $leMois;
$mois = getMois(date('d/m/Y'));
$lesMois = getLesDouzeDerniersMois($mois);

switch ($action) {
    case 'selectionnerUtilisateur':
        $lesCles = array_keys($lesVisiteurs);
        $visiteursASelectionner = $lesCles[0];
        include 'vues/v_listeVisiteurs.php';
        break;

    case 'validerFicheFrais':
        if (empty($lesFraisForfait) && (empty($lesFraisHorsForfait))) {
            ajouterErreur('Pas de fiche de frais pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            header("Refresh: 2;URL=index.php?uc=validerFicheFrais&action=selectionnerUtilisateur");
        } else {
            $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $leMois);
            include 'vues/v_validerFicheFrais.php';
        }
        break;

    case 'majForfait':
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $leMois, $lesFrais);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
        }
        ajouterErreur('Les frais forfait ont bien été mis à jour.');
        include 'vues/v_erreurs.php';
        $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $leMois);
        include 'vues/v_validerFicheFrais.php';
        break;

    case 'majHorsForfait':
        $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $leMois);

        if (isset($_POST['corrigerFHF'])) {
            $pdo->majFraisHorsForfait($idVisiteur, $leMois, $libelle, $date, $montant, $unIdFrais);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
            ajouterErreur('Le frais hors forfait a bien été mis à jour.');
            include 'vues/v_erreurs.php';
            include 'vues/v_validerFicheFrais.php';
        } elseif (isset($_POST['supprimerFHF'])) {
            $pdo->supprimerFraisHorsForfait($unIdFrais);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
            ajouterErreur('Le frais hors forfait a bien été supprimé.');
            include 'vues/v_erreurs.php';
            include 'vues/v_validerFicheFrais.php';
        } elseif (isset($_POST['reporterFHF'])) {
            $libelle2 = "REFUSER " . $libelle;
            $pdo->majFraisHorsForfait($idVisiteur, $leMois, $libelle2, $date, $montant, $unIdFrais);
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
            $moisSuivant = getMoisSuivant($leMois);
            $pdo->creeNouveauFraisHorsForfait($idVisiteur, $moisSuivant, $libelle, $date, $montant, $unIdFrais);
            ajouterErreur('Le frais hors forfait a bien été repporté.');
            include 'vues/v_erreurs.php';
            include 'vues/v_validerFicheFrais.php';
        }
        break;

    case 'validerMontant';


        $totalFF = $pdo->calculerFF($idVisiteur, $leMois);
        $totalFF2 = $totalFF [0][0];
        //var_dump($totalFF2);

        $totalFHF = $pdo->calculerFHF($idVisiteur, $leMois);
        $totalFHF2 = $totalFHF [0][0];
        // var_dump($totalFHF2);

        $total = $totalFF2 + $totalFHF2;
        //var_dump($total);
        $montantValide = $pdo->totalValide($idVisiteur, $leMois, $total);
        $pdo->majEtatFicheFrais($idVisiteur, $leMois, 'VA');

        ajouterErreur('Vos frais forfaits et hors forfaits ont bien été validés');
        header("Refresh: 2;URL=index.php?uc=validerFicheFrais&action=selectionnerUtilisateur");
        include 'vues/v_erreurs.php';

        break;
}
