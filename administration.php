<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require './bdd/connex_bdd.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if ($_SESSION['id'] != 1) {
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
                <th>Ville</th>
            </tr>
            <?php
            $requete = $bdd->query('SELECT User_Type, prenom,nom,email,ville FROM utilisateur');
            while ($donnees = $requete->fetch()) {
                echo "<tr>\n\t<td>" . $donnees['User_Type'] . "</td>\n<td>" . $donnees['prenom'] . "</td>\n<td>" . $donnees['nom'] . "</td>\n<td>" . $donnees['email'] . "</td>\n<td>" . $donnees['ville'] . "</td>\n</tr>";
            }
            $requete->closeCursor();
            ?>
        </table>
        <h2>Liste des candidatures de nounous</h2>
        <table>
            <tr>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Ville</th>
                <th>Date Naissance</th>
                <th>Langue</th>
                <th>Experience</th>
                <th>Presentation</th>
                <th>Validation</th>
            </tr>
            <?php
            $req = $bdd->query("SELECT prenom,nom,ville,date_naissance,experience,information FROM utilisateur WHERE User_Type = 'pending'");
            while ($don = $req->fetch()) {
                echo "<tr>\n\t<td>" . $don['prenom'] . "</td>\n<td>" . $don['nom'] . "</td>\n<td>" . $don['ville'] . "</td>\n<td>" . $don['date_naissance'] . "</td>\n<td>" . $don['prenom'] . "</td>\n<td>" . $don['experience'] . "</td>\n<td>" . $don['information'] . "</td>\n";
                echo "<td>
                <form method='POST' action='administration.php'>\n
                <input type='submit' class='button' name='check' value='&check;'/>\n
                <input type='submit' name='cross' value='&cross;'/>
                </form>    
                </td>";
            }
            ?>
        </tr>

        <?php
            if (isset($_POST['check'])) {
                valider();
            } elseif (isset($_POST['cross'])) {
                refuser();
            }

        function valider() {
            require './bdd/connex_bdd.php';
            echo "La nounou a été validée.";
            $req=$bdd->exec("UPDATE utilisateur SET User_Type = 'nounou' WHERE User_Type = 'pending'");
            
        }

        function refuser() {
            echo "La nounou a été refusée.";
        }

        $req->closeCursor();
        ?>
    </table>
</body>
</html>
