<?php
session_start();
require '../bdd/connex_bdd.php';
require './functionform.php';
//if ($_SESSION['User_Type'] !== 'parent') {
//    header('Location:../error403.html');
//}
//var_dump($_SESSION);
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
        <h2>Que recherchez-vous?</h2>
        <form method="POST" action="demandeGardePonctuelle.php">

            <label>les champs suivant sont obligatoires </label> <br>

            <label>nombre d'enfant</label>
            <input type="number" name="nbEnfant" min="1"  requiered/>    <br>  

            <label> choisissez votre date </label>
            <input type="date" name="date" requiered/>  <br>



            <label>choisissez l'horaire de début</label><br/>
            <input type='time' name='debut' requiered> <br>
            <label>choisissez l'horaire de fin</label><br/>
            <input type='time' name='debut' requiered> <br>

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

            <?php
            $r = $bdd->query("SELECT langue FROM langue");
            echo '<label> Sélectionnez la langue pour la garde : ';
            $result = $r->fetchAll(PDO::FETCH_COLUMN);
            select('langue', $result);
            ?>
            <br/><input type="submit" value="Recherche une nounou"/><br/>
        </form>
<?php
var_dump($_POST);
?>
    </body>
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
</html>