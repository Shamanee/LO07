<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
/**
 * Differents formulaires pour modifier le profil d'un utilisateur
 *      L'utilisateur peut donc modifier sa photo de profil, son mot de passe et ses informations
 */
session_start();
require './bdd/connex_bdd.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta author="Timothée Drouot, Thomas Conroux">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <?php
        include './menu.php';
        ?>
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center infomodif">
                        <h2>Changer de photo de profil</h2>
                        <form method="POST" action="modification_profil_traitement.php" enctype="multipart/form-data" >
                            <label>Photo de profil</label>
                            <input type="file" name="photo[]" id="photo" style="margin: auto" class="form-control-file" required/><br/>
                            <input type="submit" class="btn" name="submit_photo" value="Envoyer"/><br/>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center infomodif">
                        <h2>Changer de mot de passe</h2>
                        <form method="POST" action="modification_profil_traitement.php" class="form-horizontal" >
                            <div style="margin-bottom: 25px;margin-left: auto;margin-right: auto;" class="input-group">
                                <div style="margin-bottom: 25px" class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" name="ancien_password" class="form-control" placeholder="Ancien Mot de Passe"/><br/>
                                </div>
                                <div style="margin-bottom: 25px" class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" name="new_password" class="form-control" placeholder="Nouveau Mot de Passe"/><br/>
                                </div>
                                <input type="submit" class="btn" name="submit_pass" value="Valider"/><br/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="text-center infomodif">
                        <h2>Changer les informations</h2>
                        <form method="POST" action="modification_profil_traitement.php">
                            <label>Information</label><br/>
                            <textarea name="information" class='form-control'>
                                <?php
                                /**
                                 * Requete a la base de données pour ajouter les informations modifiées dans le tuple correspondant a l'utilisteur
                                 */
                                $req = $bdd->prepare('SELECT information FROM utilisateur WHERE id=:id');
                                $req->execute(array('id' => $_SESSION['id']));
                                $info = $req->fetch();
                                echo $info['information'];
                                ?>
                            </textarea><br/>
                            <?php
                            /**
                             * Si l'utilisateur est une nounou, elle pourra modifier son expérience
                             * Un textarea apparait donc dans le formulaire
                             */
                            if ($_SESSION['User_Type'] == 'nounou') {
                                $r = $bdd->prepare('SELECT experience FROM utilisateur WHERE id=:id');
                                $r->execute(array('id' => $_SESSION['id']));
                                $exp = $r->fetch();
                                //var_dump($exp);
                                //echo 'experience';
                                echo "<label>Experience</label><br/>\n
                    <textarea name='experience' class='form-control'>\n";
                                echo $exp['experience'] . "\n";
                                echo "</textarea><br/>\n";
                            }
                            ?>
                            <input type="submit" class="btn" name="submit_info" value="Valider"/>
                        </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </section>
        <?php require './footer.html';?>
    </body>
</html>
