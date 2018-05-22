<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require './connex_bdd.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Page de Profil</title>
    </head>
    <body>
        <?php
        include './menu.php';
        ?>
        <?php
        if($_SESSION['User_Type']=='parent')
        {
            echo"<h1>PARENT</h1>\n";
            echo $_SESSION['prenom']." ".$_SESSION['nom']."<br/>\n";
            echo "\n";
        }else if($_SESSION['User_Type']=='nounou'){
            echo"<h1>NOUNOU</h1>\n";
        }else if($_SESSION['id']==1){
            echo"<h1>ADMIN</h1>\n";
            echo"vous avez beaucoup de droits<br/>\n";
        }else{
            header('location: error403.html');
        }
        ?>
        <?php
        $photoprofil=$bdd->prepare('SELECT photo FROM utilisateur WHERE id=:id');
        $photoprofil->execute(array('id'=>$_SESSION['id']));
        
        while($donnees=$photoprofil->fetch()){
            if(isset($donnees['photo'])){
                echo "<img src='".$donnees['photo']."' name='photo_profil' alt='Photo de profil' height='100px'/><br/>\n";
            }else{
                echo "<img src='photo/blank_photo' name='photo_profil' alt='Photo de profil' height='100px'/><br/>\n";
            }
        }
        $photoprofil->closeCursor();
        ?>
        <a href='modification_profil.php'>Modifier Profil</a><br/>
        <a href="accueil.php">Retour</a>
    </body>
</html>
