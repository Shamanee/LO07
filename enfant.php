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
        /**
         * Si l'utilisateur n'est pas un parent, on lui affiche qu'il n'a pas les droits d'accéder à la page avec un Erreur403
         */
        if($_SESSION['User_Type']!='parent'){
            header('location: error403.html');
        }
        ?>
        <?php
        include './menu.php';
        ?>
        <h2>Liste Enfants</h2>
        <table>
            <tr>
                <th>Prenom</th>
                <th>Date Naissance</th>
            </tr>
            <?php
            /**
             * On fait une requete à la base de données pour récupérer les enfants de l'utilisateur
             * Les enfants seront ensuite affichés dans un tableau
             */
            require './bdd/connex_bdd.php';
            $requete=$bdd->prepare('SELECT Prenom, Date_Naissance FROM enfant WHERE utilisateur_id = ?');
            $requete->execute(array($_SESSION['id']));
            while($donnees=$requete->fetch()){
                echo "<tr>\n\t<td>".$donnees['Prenom']."</td>\n<td>".$donnees['Date_Naissance']."</td>\n";
            }
            $requete->closeCursor();
            ?>
        </table>
        <br/><br/>
        <h2>Ajouter un enfant</h2>
        <form method="post" action="enfant_traitement.php">
            <label>Prenom</label>
            <input type="text" name="prenom"/><br/>
            <label>Date de Naissance</label>
            <input type="date" name="date_naissance"/><br/>
            <input type="submit" value="Ajouter"/>
        </form>
        <a href="accueil.php">Accueil</a>
    </body>
</html>
