<?php
/**
 * Vue Liste des visteurs
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
<h2> Valider la fiche de frais</h2>
<br> <!-- Ligne vide ajoutée ici -->
<div class="row">
    <div class="col-md-6">
        <label for="lstVisiteurs" accesskey="n">Sélectionner un visiteur :</label>
        <form action="index.php?uc=validerFicheFrais&action=validerFicheFrais" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n"></label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
<?php
foreach ($lesVisiteurs as $unVisiteur) {
    $id = $unVisiteur['id'];
    $nom = $unVisiteur['nom'];
    $prenom = $unVisiteur['prenom'];
    ?>
                        <option value="<?php echo $id ?>">
                        <?php echo $nom . " " . $prenom ?> </option>
                            <?php
                        }
                        ?>
                </select>
            </div>

    </div>
    <div class="col-md-6">
        <label for="lstMois" accesskey="n">Sélectionner un mois :</label>
        <div class="form-group">
            <label for="lstMois" accesskey="n"></label>
            <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

            </select>
        </div>

    </div>

    <div class="text-center">
        <input id="ok" type="submit" value="Valider" class="btn btn-success" role="button">
        <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" role="button">
        </form>  
    </div>
</div>