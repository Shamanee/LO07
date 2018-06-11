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

            <label>les champs suivant sont obligatoires </label> <br>

            <label>Choisissez vos enfants à garder</label>
            <?php
            $req=$bdd->query("SELECT Prenom FROM enfant WHERE utilisateur_id=".$_SESSION['id']."");
            $res = $req->fetchAll(PDO::FETCH_COLUMN);
            checkbox('enfant', $res);
            ?><br>  

            <label> choisissez votre date </label>
            <input type="date" name="date" requiered/>  <br>



            <label>choisissez l'horaire de début</label><br/>
            <input type='time' name='debut' requiered> <br>
            <label>choisissez l'horaire de fin</label><br/>
            <input type='time' name='fin' requiered> <br>

            

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
</html>