<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require './bdd/connex_bdd.php';
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
        <script type="text/javascript" src="function_js.js"></script>
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
         * Ici, on regarde si une idée a été définie. Si ce n'est pas le cas, on renvoie à l'écran de connexion.
         * Si c'est bon, on affiche le menu en rapport avec le type d'utilisateur de la session.
         */
        //var_dump($_SESSION);
        if (!isset($_SESSION['id'])) {
            header('location: connexion.php');
            exit;
        } else {
            if ($_SESSION['User_Type'] === 'nounou') {
                $re = $bdd->query("SELECT COUNT(jour) FROM disponibilite WHERE utilisateur_id='" . $_SESSION['id'] . "'");
                $res = $re->fetchAll();
                //var_dump($res[0]);
                $req = $bdd->query("SELECT COUNT(*) FROM utilisateur_has_langue WHERE utilisateur_id='" . $_SESSION['id'] . "'");
                $resu = $req->fetchAll();
                //var_dump($resu[0]);
                if ($res[0]['COUNT(jour)'] === '0') {
                    echo'etst';
                    echo '<script>premiere_co_nounou_dispo()</script>';
                }
                if ($resu[0]['COUNT(*)'] === '0') {
                    echo 'test';
                    echo '<script>premiere_co_nounou_langue()</script>';
                }
            }
            require './menu.php';
            ?>
            <div class="container-fluid" style="background-color: #ffd1dd">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">

                        <div class="item active">
                            <img src="photo/fond1.jpg" alt="Los Angeles" style="max-height: 400px; width:100%;opacity: 0.1">
                            <div class="carousel-caption">
                                <h3>Gardes Ponctuelles</h3>
                                <p>Besoin d'une garde ponctuelle ?</p>
                                <p>Choisissez la date et les enfants que vous voulez faire gardez. Nous vous sélectionnons les nounous disponibles</p>
                                <p>Tarif : 7&euro;/heure (+4&euro;/heure pour chaque enfant supplémentaire)</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="photo/fond1.jpg" alt="Chicago" style="max-height: 400px; width:100%;opacity: 0.1">
                            <div class="carousel-caption">
                                <h3>Gardes Régulière</h3>
                                <p>Besoin de compter sur quelqu'un pour garder vous enfants chaque semaine ?</p>
                                <p>Choisissez les jours et les heures de gardes, nous vous trouvons les nouonus disponibles</p>
                                <p>Tarif : 10&euro;/heure (+5&euro;/heure pour chaque enfant supplémentaire)</p>
                            </div>
                        </div>

                        <div class="item">
                            <img src="photo/fond1.jpg" alt="New York" style="max-height: 400px; width:100%; opacity: 0.1">
                            <div class="carousel-caption">
                                <h3>Garde Etrangère</h3>
                                <p>Votre enfant ne parle pas le français ?</p>
                                <p>Choisissez la langue que vous voulez, puis la date et l'heure de la garde, nous vous trouvons les nounous disponibles</p>
                                <p>Tarif : 15&euro;/heure et pour chaque enfant</p>
                            </div>
                        </div>

                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="container-fluid bg-1">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div id="accueil" class="col-md-8 rounded bg-2">
                        <?php
                        echo "<h2>Bonjour " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . "</h2>\n\t\t";
                    }
                    ?>
                </div>
                <div class="col-md-2"></div>
            </div>  
        </div>
        <!--<ul>
        <?php
        /* if($_SESSION['User_Type']=='parent'){
          echo"<li><a href='reservation.php'>Réserver</a></li>\n";
          echo"<li><a href='enfant.php'>Vos enfants</a></li>\n";
          }
          ?>
          <li><a href="profil.php">Profil</a></li>
          <?php
          if($_SESSION['id']==1){
          echo "<li><a href='administration.php'>Administration</a></li>\n";
          } */
        ?>
        </ul>
        <form method="post" action="deconnexion.php">
            <input type="submit" value="Déconnexion"/>
        </form>-->
    </body>
    <?php    require 'footer.html';?>
</html>
