<?php
session_start();
//require '../bdd/connex_bdd.php';
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
//var_dump($_SESSION);
//$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
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
        <?php
        require './menu_parent.php';
        ?>
        <h2>Que recherchez-vous?</h2>

        <form method="POST" action='demandeGarde.php'>
            <label>choix</label><br/>
            <input type="radio" name='choix' id="ponctuelle" value='ponctuelle'/><label for='ponctuelle'>Une garde ponctuelle</label><br/>
            <input type="radio" name="choix" id="reguliere" value="reguliere"/><label for='reguliere'>Une garde régulière</label><br/>
            <input type="radio" name="choix" id="etrangere" value="etrangere"/><label for='etrangere'>Une garde étrangère</label><br/>
            <input type="submit" value="Envoyer" name='submit'/>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            if ($_POST['choix'] === 'ponctuelle') {
                header('location:demandeGardePonctuelle.php');
            } else if ($_POST['choix'] === 'reguliere'){
                header('location:demandeGardeReguliere.php');
            } else if ($_POST['choix'] === 'etrangere') {
                header('location:demandeGardeEtrangere.php');
            }
        }
        ?>


    </body>
</html>