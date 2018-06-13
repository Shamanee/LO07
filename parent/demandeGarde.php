<?php
session_start();
//require '../bdd/connex_bdd.php';
//if ($_SESSION['User_Type'] !== 'parent') {
//    header('Location:error403.html');
//}
//var_dump($_SESSION);
//$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
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