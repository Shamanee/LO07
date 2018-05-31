<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if ($_SESSION['User_Type'] = !'nounou') {
    header('Location:error403.html');
}
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
        <h2>Vos disponibilités</h2>
        <form method="POST" action="dispo_form.php">
            <label>Choix des jours de disponibilité</label><br/>
            <?php
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
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
        
        <?php
        var_dump($_POST);
        ?>
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