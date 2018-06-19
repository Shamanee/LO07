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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <style>
            .dispo_jour{
            }
        </style>
    </head>
    <body>
        <h2>Que recherchez-vous?</h2>
        <form method="POST" action="demandeGardePonctuelle.php">

            <label>Choisissez vos enfants à garder</label>
            <?php
            $req = $bdd->query("SELECT Prenom FROM enfant WHERE utilisateur_id=" . $_SESSION['id'] . "");
            $res = $req->fetchAll(PDO::FETCH_COLUMN);
            checkbox('enfant[]', $res);
            ?><br>  

            <label> choisissez votre date </label>
            <input type="date" name="date" requiered/>  <br>



            <label>choisissez l'horaire de début</label><br/>
            <input type='time' name='debut' requiered> <br>
            <label>choisissez l'horaire de fin</label><br/>
            <input type='time' name='fin' requiered> <br>

            <br/><input type="submit" name='submit' value="Recherche une nounou"/><br/>
        </form>
        <?php
        var_dump($_POST);
        if (isset($_POST['submit'])) {
            //var_dump($_POST);
            echo '<form method = "POST" action="gardePonctuelle_traitement.php">';
            //var_dump($result);
            $array_nounou = [];
            $date = $_POST['date'];
            $date_prest = date_create($date);
            //var_dump($date_prest);
            $j = $date_prest->format('w');
            $jour = $j - 1;
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

                        <input type="radio" name='nounou' id='<?= $nom_nounou ?>' value="<?= $nom_nounou ?>"/><label for="<?= $nom_nounou ?>"><?= $nom_nounou ?></label>
                        <input type="hidden" name="heure_debut" value="<?= $_POST["debut"] ?>"/>
                        <input type="hidden" name="heure_fin" value="<?= $_POST["fin"] ?>"/>
                        <input type="hidden" name='date' value="<?= $_POST['date'] ?>"/>
                        <?php
                        foreach ($_POST['enfant'] as $enfant):
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
            <input type="submit" name="submit" value='Choisir la nounou'/>
        </form>
        <?php
    }
    ?>
</body>
</html>
