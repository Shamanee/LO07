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
        <title>Accueil</title>
    </head>
    <body>
        <?php
        /**
         * Ici, on regarde si une idée a été définie. Si ce n'est pas le cas, on renvoie à l'écran de connexion.
         * Si c'est bon, on affiche le menu en rapport avec le type d'utilisateur de la session.
         */
        //var_dump($_SESSION);
        if(!isset($_SESSION['id'])){
            header('location: connexion.php');
            exit;
        }else{
            require './menu.php';
            echo "Bonjour ".$_SESSION['prenom']." ".$_SESSION['nom']."<br/>\n\t\t";
            echo "Bienvenue sur super-nounou.fr<br/>\n";
        }
        ?>
        
        <!--<ul>
            <?php
            /*if($_SESSION['User_Type']=='parent'){
                echo"<li><a href='reservation.php'>Réserver</a></li>\n";
                echo"<li><a href='enfant.php'>Vos enfants</a></li>\n";
            }
            ?>
            <li><a href="profil.php">Profil</a></li>
            <?php
            if($_SESSION['id']==1){
                echo "<li><a href='administration.php'>Administration</a></li>\n";
            }*/
            ?>
        </ul>
        <form method="post" action="deconnexion.php">
            <input type="submit" value="Déconnexion"/>
        </form>-->
    </body>
</html>
