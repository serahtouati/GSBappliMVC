<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Modification du mot de passe</h3>
            </div>
            <div class="panel-body">
                <form role="form" method="post" 
                      action="index.php?uc=modifierMdp&action=modificationMdp">
                    <fieldset>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input class="form-control" placeholder="Login"
                                       name="login" type="text" maxlength="45">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-lock"></i>
                                </span>
                                <input class="form-control"
                                       placeholder="Mot de passe actuel" name="mdp"
                                       type="password" maxlength="45">
                            </div>
                        </div>
                                                <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-lock"></i>
                                </span>
                                <input class="form-control"
                                       placeholder="Nouveau mot de passe " name="nouveauMdp"
                                       type="password" maxlength="45">
                            </div>
                        </div>
                                                <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-lock"></i>
                                </span>
                                <input class="form-control"
                                       placeholder="Confirmation du nouveau mot de passe" name="nouveauMdp2"
                                       type="password" maxlength="45">
                            </div>
                        </div>
                        <input class="btn btn-lg btn-success btn-block"
                               type="submit" value="Enregistrer">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>