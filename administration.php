<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
/**
 * On ouvre une session on appelle la connexion à la Base de Données
 */
session_start();
require './bdd/connex_bdd.php';
//require './administration/function.php';
require 'classe/Week.php';
require 'classe/Month.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <script type="text/javascript" src="function_js.js"></script>
        <script src='jQuery/jquery-3.3.1.min.js'></script>
        <meta author="Timothée Drouot, Thomas Conroux">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <title></title>
    </head>
    <body>
        <?php
        /**
         * On empeche les personnes qui n'ont pas le compte admin d'accéder à la page administration
         * En les renvoyant sur une page erreur403 qui indique "Interdit"
         */
        if ($_SESSION['id'] != 1) {
            header("location: error403.html");
        }
        ?>
        <?php
        include './menu.php';
        ?>

        <?php
        require './administration/liste_utilisateur.php';
        /**
         * On fait une requete pour savoir les nounous qui sont dans l'attente d'acceptation (User_Type = pending)
         * Si la requete est vide, on n'affiche rien
         * Si elle ne l'est pas, on affiche un tableau contenant les informations sur les nounous à valider
         */
        $ree = $bdd->query("SELECT COUNT(*) FROM utilisateur WHERE User_Type = 'pending'");
        $ress = $ree->fetch();
        $nbCandidature = $ress['COUNT(*)'];
        $sql = "SELECT prenom,nom,ville,date_naissance,experience,information,id FROM utilisateur WHERE User_Type = 'pending'";
        $r = $bdd->query($sql);
        $res = $r->fetchAll();
        if (!empty($res[0]['prenom'])) {
            ?>
            <h2>Liste des candidatures de nounous (<?= $nbCandidature ?> candidatures)</h2>
            <table class="table table-bordered table-striped">
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
                <input type='hidden' name='idaccept' value='" . $don['id'] . "'/>
                </form>    
                </td>";
                    /**
                     * On fait un formulaire pour traiter les demdandes. Une confirmation (avec un pop-up) sera demander à l'admin pour valider son choix
                     */
                }
                ?>
            </tr>

            <?php
        }
        $requete->closeCursor();
        ?>

    </table>
    <?php require 'footer.html'; ?>
</body>
</html>
