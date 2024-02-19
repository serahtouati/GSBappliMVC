<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2> Suivre le paiement des fiches de frais</h2>
   <div class="row">
        <div class="col-md-4">
              <form method="post"  action="index.php?uc=suivrePaiement&action=valider"
            <label for="lstVisiteurs" accesskey="n">Sélectionner un visiteur :</label>
            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n"></label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) {
                        $id = $unVisiteur['id'];
                        $nom = $unVisiteur['nom'];
                        $prenom = $unVisiteur['prenom'];
                        if ($id == $visiteurASelectionner) {
                            ?>
                            <option selected value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id ?>">
                                <?php echo $nom . ' ' . $prenom ?> </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="col-md-4">
            <label for="lstMois" accesskey="n">Sélectionner un mois :</label>
            <div class="form-group">
                <label for="lstMois" accesskey="n"></label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                    foreach ($lesMois as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = substr($mois, 0, 4);
                        $numMois = substr($mois, 4, 2);
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
    </div>

                               <input id="valider" name="valider" type="submit" value="Valider" class="btn btn-success"/>  
      <input id="effacer" name="effacer" type="reset"value="Effacer"  class="btn btn-danger"/>  
</form>
            
            