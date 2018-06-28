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
        <?php
        /**
         * Si l'utilisateur n'est pas un parent, on lui affiche qu'il n'a pas les droits d'accéder à la page avec un Erreur403
         */
        if ($_SESSION['User_Type'] != 'parent') {
            header('location: error403.html');
        }
        ?>
        <?php
        include './menu.php';
        ?>
        <div class="container">
            <div class="row">
                <h2>Liste Enfants</h2>
                <table class="table table-bordered table-striped">
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
                    $requete = $bdd->prepare('SELECT Prenom, Date_Naissance FROM enfant WHERE utilisateur_id = ?');
                    $requete->execute(array($_SESSION['id']));
                    while ($donnees = $requete->fetch()) {
                        echo "<tr>\n\t<td>" . $donnees['Prenom'] . "</td>\n<td>" . $donnees['Date_Naissance'] . "</td>\n";
                    }
                    $requete->closeCursor();
                    ?>
                </table>
                <br/><br/>
                <h2>Ajouter un enfant</h2>
                <form method="post" action="enfant_traitement.php">
                    <div class="col-md-6">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="prenom" placeholder="Prénom" class="form-control"/><br/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input type="date" name="date_naissance" class="form-control"/><br/>
                        </div>
                    </div>
                    <div class="text-center" style="margin-bottom: 10px ">
                    <input type="submit" class="btn btn-primary" value="Ajouter"/>
                    </div>
                </form>
            </div>
        </div>
        <?php require 'footer.html'; ?>
    </body>
</html>
