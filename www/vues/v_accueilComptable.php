<?php
/**
 * Vue Accueil
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
?>
<div id="accueil">
    <h2>
        Gestion des frais<small> - Comptable : 
            <?php 
            echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']
            ?></small>
    </h2>
</div> 
<div class="row">
    <div class="col-md-12">
        <div style="border-color: coral" class="panel panel-primary">
            <div style="background-color: coral" class="panel-heading">
                <h3 class="panel-title" style=border-bottom: coral> 
                    <span class="glyphicon glyphicon-bookmark"></span>
                    Navigation
                </h3>
            </div>
            <div class="panel-body">
                <div  class="row">
                    <div class="col-xs-12 col-md-12">
                        <a  href="index.php?uc=validerFicheFrais&action=selectionnerUtilisateur"
                           class="btn btn-success btn-lg" role="button">
                            <span class="glyphicon glyphicon-check"></span>
                            <br>Valider la fiche de frais</a>
                        <a style="background-color: coral ; border-color: coral"  href="index.php?uc=suivrePaiement&action=selectionnerUtilisateur"
                           class="btn btn-primary btn-lg" role="button">
                            <span class="glyphicon glyphicon-euro"></span>
                            <br>Suivre le paiement des fiches de frais</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

