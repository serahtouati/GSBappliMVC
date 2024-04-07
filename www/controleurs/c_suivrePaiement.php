<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
    case 'selectionnerUtilisateur':
        $lesVisiteurs = $pdo->getNomVisiteurVA();
        $lesCles = array_keys($lesVisiteurs);   
        $visiteursASelectionner = $lesCles[0];
        $lesMois = $pdo->getLesMoisDisponiblesVA();
        include 'vues/v_visiteurVA.php';
        break;

    case 'valider':
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        $ficheValide = $pdo->getVisiteurMoisVA($leMois, $idVisiteur);
        //var_dump($ficheValide);
       if ($ficheValide) {
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        //$moisASelectionner = $leMois;
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
        } else {
            ajouterErreur('Pas de fiche de frais validée pour ce visiteur ce mois');
            include 'vues/v_erreurs.php';
            header("Refresh: 2;URL=index.php?uc=suivrePaiement&action=selectionnerUtilisateur");
        }
        break;
    case 'remboursement':
        //echo "coucou";
      
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
        
        var_dump($leMois, $idVisiteur);
        $pdo->majEtatFicheFrais($idVisiteur, $leMois, 'RB');
        
        ajouterErreur('Les frais ont bien été remboursés.');
        header("Refresh: 2;URL=index.php?uc=suivrePaiement&action=selectionnerUtilisateur");
        include 'vues/v_erreurs.php';
        break;
}