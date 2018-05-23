<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start();
require './connex_bdd.php';
setlocale(LC_ALL, 'FR_fr');
require './Calendrier.php';
$calendrier = new Calendrier();
/*
  echo '<pre>';
  print_r($calendrier->calendar());
  echo '</pre>'; */
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planing <?php
            $req = $bdd->prepare('SELECT prenom,nom FROM utilisateur WHERE id=:id');
            $req->execute(array('id' => $_SESSION['id']));
            $resultat = $req->fetch();
            echo $resultat['prenom'] . " " . $resultat['nom'];
            ?></title>
    </head>
    <body>
        <?php
        if ($_SESSION['User_Type'] != 'nounou') {
            header('location: error403.html');
        }
        ?>
        <h1>Votre Planning</h1>
        <div id="main">
            <div class="row">
                <h3><?= $calendrier->afficheMois(); ?> &nbsp;<?= $calendrier->afficheAnnee(); ?></h3>

                <a href="planning.php?month=<?= $calendrier->afficheAnneePrecedent(); ?>" class="btn btn-warning"> << <?php echo $calendrier->afficheAnneePrecedent(); ?></a>

                &nbsp;

                <a href="planning.php?month=<?= $calendrier->afficheMoisPrecedent(); ?>" class="btn"> <<  <?= $calendrier->afficheMoisPrecedent(); ?></a>

                &nbsp;&nbsp;&nbsp;&nbsp;

                <a href="planning.php?month=<?= $calendrier->afficheAnneeSuivant(); ?>" class="btn btn-warning"> >> <?php echo $calendrier->afficheAnneeSuivant(); ?></a>

                &nbsp;

                <a href="planning.php?month=<?= $calendrier->afficheMoisSuivant(); ?>" class="btn"> >>  <?= $calendrier->afficheMoisSuivant(); ?></a>

            </div>
            <table class="tableau">
                <thead>
                    <tr>
                        <?php $calendrier->afiicheNomJour(); ?> 

                    </tr>
                </thead>

                <tbody>	
                    <tr>
                        <?php $calendrier->afiicheNumeroJour(); ?>
                    </tr>
                </tbody>
            </table>

        </div>
    </body>
</html>
