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
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta author="Timothée Drouot, Thomas Conroux">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <h2>Vos langues</h2>
        <form method="POST" action="langue_form_traitement.php">
            <label>Langues</label><br/>
            <select name="langue[]" size="5" multiple>
                <?php
                $req = $bdd->query('SELECT * FROM langue');
                while ($donnees = $req->fetch()) {
                    echo "<option value=" . $donnees['Langue'] . ">" . $donnees['Langue'] . "</option>";
                }
                ?>
            </select><br/>
            <input type="submit" value="envoyer"/>
        </form>
    </body>
</html>
