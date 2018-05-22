<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require './connex_bdd.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include './menu.php';
        ?>
        <h2>Changer de photo de profil</h2>
        <form method="POST" action="modification_profil_traitement.php" enctype="multipart/form-data">
            <label>Photo de profil</label>
            <input type="file" name="photo[]" id="photo" required/><br/>
            <input type="submit" name="submit_photo" value="Envoyer"/><br/>
        </form>
        <hr/>
        <h2>Changer de mot de passe</h2>
        <form method="POST" action="modification_profil_traitement.php">
            <label>Ancien mot de passe</label>
            <input type="password" name="ancien_password"/><br/>
            <label>Nouveau mot de passe</label>
            <input type="password" name="new_password"/><br/>
            <input type="submit" name="submit_pass" value="Valider"/><br/>
        </form>
        <hr/>
        <h2>Changer les informations</h2>
        <form method="POST" action="modification_profil_traitement.php">
            <label>Information</label>
            <textarea name="information">
                <?php
                $req=$bdd->prepare('SELECT information FROM utilisateur WHERE id=:id');
                $req->execute(array('id'=>$_SESSION['id']));
                $info=$req->fetch();
                echo $info['information'];
                ?>
            </textarea><br/>
            <?php
            if($_SESSION['User_Type']=='nounou'){
                $r=$bdd->prepare('SELECT experience FROM utilisateur WHERE id=:id');
                $r->execute(array('id'=>$_SESSION['id']));
                $exp=$r->fetch();
                echo $info['experience'];
                echo "<label>Experience</label>\n
                    <textarea name='experience'>\n";
                echo $exp['experience'] . "\n";
                echo "</textarea><br/>\n";
            }
            ?>
            <input type="submit" name="submit_info" value="Valider"/>
        </form>
    </body>
</html>
