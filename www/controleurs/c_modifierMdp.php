<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if (!$uc) {
    $uc = 'modifierMdp';
}

switch ($action) {
case 'modificationMdp':
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $nouveauMdp = filter_input(INPUT_POST, 'nouveauMdp', FILTER_SANITIZE_STRING);
    $nouveauMdp2 = filter_input(INPUT_POST, 'nouveauMdp2', FILTER_SANITIZE_STRING);
    $a= password_verify($nouveauMdp, $nouveauMdp2);

     $visiteur = $pdo->getInfosVisiteur($login, $mdp);
    $comptable = $pdo->getInfosComptable($login, $mdp);
    
    if (!is_array($visiteur) && (!is_array($comptable)) ){
        ajouterErreur('Login ou mot de passe incorrect');
        include 'vues/v_erreurs.php';
    } elseif (is_array($visiteur) &&  (!($a))) {
        $pdo->modifierMdpVisiteur($login, $nouveauMdp2);
    
        
    } elseif(is_array($comptable)  &&  (!($a))){
    
        $pdo->modifierMdpComptable($login, $nouveauMdp2);
    }
    include 'vues/v_modifierMdp.php';
    break;

}