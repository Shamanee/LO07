<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require '../bdd/connex_bdd.php';
require './functionform.php';
require './function_prix.php';
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
//var_dump($_SESSION);
$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta author="Timothée Drouot, Thomas Conroux">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <title></title>
    </head>
    <body>
        <?php require './menu_parent.php'; ?>
        <div class="container">
            <div class="row">
                <h2>Que recherchez-vous?</h2>
                <form method="POST" action="demandeGardeReguliere.php" class="form-horizontal">
                    <?php
                    foreach ($jours as $jour):
                        echo "<div class='checkbox'>";
                        echo "<input type='checkbox' class='jour' name='" . $jour . "' value='" . $jour . "' id='" . $jour . "'/><label for='" . $jour . "'>" . $jour . "</label><br/>\n";
                        echo "</div>";
                        ?>
                        <div id="dispo_<?= $jour ?>" style="display:none">
                            <div style="height: 75px;">
                                <div class="col-md-6">
                                    <label>Heure de début</label>
                                    <input type="time" class="form-control" id="heure_deb_<?= $jour ?>" name="heure_debut_<?= $jour ?>"/><br/>
                                </div>
                                <div class="col-md-6">
                                    <label>Heure de fin</label>
                                    <input type="time" class="form-control" id="heure_fin_<?= $jour ?>" name="heure_fin_<?= $jour ?>"/><br/>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach;
                    ?>
                    <label>Date maximum de la garde régulière</label>
                    <input type="date" class="form-control" name="datemax"/>
                    <div class="text-center">
                        <br/><input type="submit" class="btn btn-primary" name='submit' value="Rechercher une nounou"/><br/>
                    </div>
                </form>
                <?php
                if (isset($_POST['submit'])) {
                    //var_dump($_POST);
                    echo '<form method = "POST" action="gardeReguliere_traitement.php">';
                    foreach ($jours as $k => $value) {

                        //var_dump($result);
                        if (isset($_POST[$value])) {

                            $array_nounou = [];
                            $jour = $_POST[$value];
                            if (isset($jour)) {
                                ?>
                                <label>Choisissez vos enfants à garder</label>

                                <?php
                                $req = $bdd->query("SELECT Prenom FROM enfant WHERE utilisateur_id=" . $_SESSION['id'] . "");
                                $res = $req->fetchAll(PDO::FETCH_COLUMN);
                                checkbox('enfant[]', $res);
                                echo '<br>';

                                echo "<br/>Pour le $value, nous vous proposon cette (ces) nounou(s) :<br/>\n";
                                $h_deb = $_POST["heure_debut_" . $jour . ""];
                                $h_fin = $_POST["heure_fin_" . $jour . ""];
                                $heure_debut = date_create_from_format('H:i', $h_deb);
                                $heure_fin = date_create_from_format('H:i', $h_fin);
                                if ($heure_debut != FALSE && $heure_fin != FALSE) {
                                    $heure_debut = $heure_debut->format('H:i:s');
                                    $heure_fin = $heure_fin->format('H:i:s');
                                }
                                //                        var_dump($h_deb);
                                //                        var_dump($h_fin);
                                //                        var_dump($heure_debut);
                                //                        var_dump($heure_fin);
                                $r = $bdd->query("SELECT D.utilisateur_id, D.jour, D.Debut, D.Fin, U.nom FROM disponibilite D, utilisateur U WHERE D.jour=$k AND D.utilisateur_id = U.id AND U.User_Type='nounou'");
                                $result = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $res) {
                                    //var_dump($res);

                                    if ($heure_debut >= $res['Debut'] && $heure_fin <= $res['Fin']) {
                                        //$array_nounou[] = $res['nom'];
                                        $nom_nounou = $res['nom'];
                                        //var_dump($res['nom']);
                                        ?>
                                        <div class="radio">
                                            <input type="radio" name='nounou_<?= $res ['jour'] ?>' id='<?= $nom_nounou ?>' value="<?= $nom_nounou ?>"/><label><a href="../profil-nounou.php?nom=<?= $nom_nounou ?>"><?= $nom_nounou ?></a></label>
                                        </div>
                                        <input type="hidden" name="heure_debut_<?= $res['jour'] ?>" value="<?= $_POST["heure_debut_$jour"] ?>"/>
                                        <input type="hidden" name="heure_fin_<?= $res['jour'] ?>" value="<?= $_POST["heure_fin_$jour"] ?>"/>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    <br/>
                    <input type="hidden" name="datemax" value="<?= $_POST['datemax'] ?>"/>
                    <div class="text-center" style="margin-bottom: 10px;">
                        <input type="submit" class="btn btn-primary" name="submit" value='Choisir la nounou'/>
                    </div>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php require '../footer.html';?>
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
