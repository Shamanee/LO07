<?php
session_start();
require '../bdd/connex_bdd.php';
require './functionform.php';
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
//var_dump($_SESSION);
$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            .dispo_jour{
            }
        </style>
        <meta author="Timothée Drouot, Thomas Conroux">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <?php require './menu_parent.php'; ?>
        <div class="container">
            <div class="row">
                <h2>Que recherchez-vous?</h2>
                <form method="POST" action="demandeGardePonctuelle.php" class="form-horizontal">

                    <label>Choisissez vos enfants à garder</label>
                    <?php
                    $req = $bdd->query("SELECT Prenom FROM enfant WHERE utilisateur_id=" . $_SESSION['id'] . "");
                    $res = $req->fetchAll(PDO::FETCH_COLUMN);
                    checkbox('enfant[]', $res);
                    ?><br>  

                    <label> choisissez votre date </label>
                    <input type="date" name="date" class="form-control" requiered/>  <br>


                    <div class="col-md-6">
                        <label>choisissez l'horaire de début</label><br/>
                        <input type='time' name='debut' class="form-control" requiered> <br>
                    </div>
                    <div class="col-md-6">
                        <label>choisissez l'horaire de fin</label><br/>
                        <input type='time' name='fin'  class="form-control" requiered> <br>
                    </div>
                    <div class="text-center">
                        <br/><input type="submit" name='submit' class="btn btn-primary" value="Recherche une nounou" /><br/>
                    </div>
                </form>
                <?php
                //var_dump($_POST);
                if (isset($_POST['submit'])) {
                    echo "<hr/>";
                    //var_dump($_POST);
                    echo '<form method = "POST" action="gardePonctuelle_traitement.php">';
                    //var_dump($result);
                    $array_nounou = [];
                    $date = $_POST['date'];
                    $date_prest = date_create($date);
                    //var_dump($date_prest);
                    $j = $date_prest->format('w');
                    if ($j != 0) {
                        $jour = $j - 1;
                    } else {
                        $jour = 6;
                    }
                    echo "<br/>Pour le $date, nous vous proposon cette (ces) nounou(s) :<br/>\n";
                    $h_deb = $_POST["debut"];
                    $h_fin = $_POST["fin"];
                    $heure_debut = date_create_from_format('H:i', $h_deb);
                    $heure_fin = date_create_from_format('H:i', $h_fin);
                    if ($heure_debut != FALSE && $heure_fin != FALSE) {
                        $heure_debut = $heure_debut->format('H:i:s');
                        $heure_fin = $heure_fin->format('H:i:s');

//                        var_dump($h_deb);
//                        var_dump($h_fin);
//                        var_dump($heure_debut);
//                        var_dump($heure_fin);
                        $r = $bdd->query("SELECT D.utilisateur_id, D.jour, D.Debut, D.Fin, U.nom FROM disponibilite D, utilisateur U WHERE D.jour=$jour AND D.utilisateur_id = U.id AND U.User_Type='nounou'");
                        $result = $r->fetchAll(PDO::FETCH_ASSOC);
                        //  var_dump($result);
                        foreach ($result as $res) {
                            //var_dump($res);

                            if ($heure_debut >= $res['Debut'] && $heure_fin <= $res['Fin']) {
                                //$array_nounou[] = $res['nom'];
                                $nom_nounou = $res['nom'];
                                //var_dump($res['nom']);
                                ?>
                                <div class="radio">
                                    <input type="radio" name='nounou' id='<?= $nom_nounou ?>' value="<?= $nom_nounou ?>"/><label><a href="../profil-nounou.php?nom=<?= $nom_nounou ?>"><?= $nom_nounou ?></a></label>
                                </div>
                                <input type="hidden" name="heure_debut" value="<?= $_POST["debut"] ?>"/>
                                <input type="hidden" name="heure_fin" value="<?= $_POST["fin"] ?>"/>
                                <input type="hidden" name='date' value="<?= $_POST['date'] ?>"/>
                                <?php
                                foreach ($_POST['enfant'] as $k => $enfant):
                                    //var_dump($enfant);
                                    ?>
                                    <input type="hidden" name="enfant[]" value="<?= $enfant ?>"/>
                                    <?php
                                endforeach;
                            }
                        }
                    }
                    ?>
                    <br/>
                    <br/>
                    <div class="text-center">
                        <input type="submit" name="submit" class="btn btn-primary" value='Choisir la nounou'/>
                    </div>
                    </form>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="infomodif text-center">
                            <?php
                            echo $k + 1 . " enfants<br/>";

                            echo "prix à payer : ";
                            require './function_prix.php';
                            calculPrix_ponctuelle($_POST["debut"], $_POST["fin"], $k + 1);
                            echo " &euro;";
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </div>
        <?php require '../footer.html';?>
    </body>
</html>
