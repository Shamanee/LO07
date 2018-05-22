<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if($_SESSION['id']!=1){
            header("location: error403.html");
        }
        ?>
        <?php
        include './menu.php';
        ?>
        <h2>Liste Utilisateurs</h2>
        <table>
            <tr>
                <th>Type</th>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Email</th>
            </tr>
            <?php
            require './connex_bdd.php';
            $requete=$bdd->query('SELECT User_Type, prenom,nom,email FROM utilisateur');
            while($donnees=$requete->fetch()){
                echo "<tr>\n\t<td>".$donnees['User_Type']."</td>\n<td>".$donnees['prenom']."</td>\n<td>".$donnees['nom']."</td>\n<td>".$donnees['email']."</td>\n</tr>";
            }
            $requete->closeCursor();
            ?>
        </table>
    </body>
</html>
