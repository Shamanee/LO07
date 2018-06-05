<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require './bdd/connex_bdd.php';
if ($_SESSION['User_Type'] !== 'nounou') {
    header('Location:error403.html');
}

var_dump($_SESSION);
$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <style>
            .dispo_jour{

            }
        </style>
    </head>
    <body>
        <?php require './menu.php'; ?>
        <h2>Vos disponibilités (Générales)</h2>
        
        <?php 
            if ($_SESSION['User_Type'] === 'nounou') {
                $re = $bdd->query("SELECT COUNT(jour) FROM disponibilite WHERE utilisateur_id='" . $_SESSION['id'] . "'");
                $res = $re->fetchAll();
                var_dump($res);
                if ($res[0] !== '0') {
                    ?>
        <table>
            <tr>
                <th></th>
                <th>Heure début</th>
                <th>Heure fin</th>
            </tr>
                <?php foreach($jours as $k=>$jour){
                    $r=$bdd->query("SELECT Debut,Fin FROM disponibilite WHERE utilisateur_id='".$_SESSION['id']."' AND jour=$k");
                    $result=$r->fetch();
                    echo "<tr>\n<th>$jour</th>\n<td>".$result['Debut']."</td>\n<td>".$result['Fin']."</td>\n</tr>\n";
                }?>
        </table>
        <br/>   
        <?php
                }
            }
        ?>
        
        <form method="POST" action="dispo_form_traitement.php">
            <label>Choix des jours de disponibilité</label><br/>
            <?php
            
            foreach ($jours as $jour):
                echo "<input type='checkbox' class='jour' name='" . $jour . "' value='" . $jour . "' id='" . $jour . "'/><label for='" . $jour . "'>" . $jour . "</label><br/>\n";
                ?>
                <div id="dispo_<?= $jour ?>" style="display:none">
                    <label>Heure de début</label>
                    <input type="time" id="heure_deb_<?= $jour ?>" name="heure_debut_<?= $jour ?>"/><br/>
                    <label>Heure de fin</label>
                    <input type="time" id="heure_fin_<?= $jour ?>" name="heure_fin_<?= $jour ?>"/><br/>
                </div>
                <?php
            endforeach;
            ?>
            <input type="submit" value="envoyer"/><br/>
        </form>

        <script>
            $(".jour").on('click', function () {
                var jour = $(this).attr('id');
                if ($(this).is(':checked')) {
                    //$('#heure_deb_' + jour).show();
                    //$('#heure_fin_' + jour).show();
                    $('#dispo_' + jour).fadeIn();
                } else {
                    //$('#heure_deb_' + jour).hide();
                    //$('#heure_fin_' + jour).hide();
                    $('#dispo_' + jour).fadeOut();
                }
            });
        </script>
    </body>
</html>