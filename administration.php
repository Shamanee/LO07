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
        <script type="text/javascript" src="function_js.js"></script>
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
                if ($donnees['User_Type'] != 'admin') {
                    echo "<tr>\n\t<td>" . $donnees['User_Type'] . "</td>\n<td>" . $donnees['prenom'] . "</td>\n<td>" . $donnees['nom'] . "</td>\n<td>" . $donnees['email'] . "</td>\n<td>" . $donnees['ville'] . "</td>\n</tr>";
                }
            }
            $requete->closeCursor();
            ?>
        </table>
        <?php
        $sql = "SELECT prenom,nom,ville,date_naissance,experience,information FROM utilisateur WHERE User_Type = 'pending'";
        $r = $bdd->query($sql);
        $res = $r->fetchAll();
        if(!empty($res)){
        ?>
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
            $req = $bdd->query($sql);
            while ($don = $req->fetch()) {
                echo "<tr>\n\t<td>" . $don['prenom'] . "</td>\n<td>" . $don['nom'] . "</td>\n<td>" . $don['ville'] . "</td>\n<td>" . $don['date_naissance'] . "</td>\n<td>" . $don['prenom'] . "</td>\n<td>" . $don['experience'] . "</td>\n<td>" . $don['information'] . "</td>\n";
                echo "<td>
                <form method='POST' action='administration_traitement.php'>\n
                <input type='submit' class='button' name='check' value='&check;' onclick=\"return confirm('Vous allez accepter cette personne comme nounou, êtes vous sûr ?');\"/>\n
                <input type='submit' class='button' name='cross' value='&cross;' onclick=\"return confirm('Vous allez refuser cette personne, êtes vous sûr ?');\"/>
                </form>    
                </td>";
            }
            ?>
        </tr>

        <?php
        }
        $requete->closeCursor();
        ?>
    </table>
</body>
</html>
