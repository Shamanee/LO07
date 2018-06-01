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
