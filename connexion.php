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
        <meta author="Timothée Drouot, Thomas Conroux">
        <title>Projet LO07</title>
    </head>
    <body>
        <?php
        var_dump($_SESSION);
        /**
         * Si l'utilisateur est déjà connecté, on lui indique qu'il l'est déjà, puis on le redirige vers la page d'accueil.
         */
        if(isset($_SESSION['User_Type'])){
            if($_SESSION['User_Type']=='parent'||$_SESSION['User_Type']=='nounou'||$_SESSION['User_Type']=='admin'||$_SESSION['User_Type']=='pending'){
                echo "Vous etes déjà connecté";
                header('Refresh:2; url=accueil.php');
            }
        }else{
        ?>
        <form method='POST' action="connexion_traitement.php">
            <label>Email</label>
            <input type="text" name="email"/><br/>
            <label>Mot De Passe</label>
            <input type="password" name="password"/><br/>
            <input type="submit" value="Connexion"/>
        </form>
        <p>Pas de compte ? <a href="inscription.php">Inscrivez-vous !</a></p>
        <?php
        }
        ?>
    </body>
</html>
