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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <?php
        //var_dump($_SESSION);
        /**
         * Si l'utilisateur est déjà connecté, on lui indique qu'il l'est déjà, puis on le redirige vers la page d'accueil.
         */
        if(isset($_SESSION['User_Type'])){
            if($_SESSION['User_Type']=='parent'||$_SESSION['User_Type']=='nounou'||$_SESSION['User_Type']=='admin'||$_SESSION['User_Type']=='pending'){
                echo "Vous etes déjà connecté";
                header('Refresh:1; url=accueil.php');
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
        
        <p>super-nounou.fr</p>
        <p>Trouvez la nounou qui convient le mieux à vos enfants.</p>
        <?php
        }
        ?>
    </body>
</html>
