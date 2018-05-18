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
        <title>Page de Profil</title>
    </head>
    <body>
        <?php
        if($_SESSION['User_Type']=='parent')
        {
            echo"<h1>PARENT</h1>\n";
            echo $_SESSION['prenom']." ".$_SESSION['nom']."<br/>\n";
            echo "<a href=''>Modifier Profil</a><br/>\n";
        }else if($_SESSION['User_Type']=='nounou'){
            echo"<h1>NOUNOU</h1>\n";
        }else if($_SESSION['id']==1){
            echo"<h1>ADMIN</h1>\n";
            echo"vous avez beaucoup de droits\n";
        }else{
            header('location: error403.html');
        }
        ?>
        <a href="accueil.php">Retour</a>
    </body>
</html>
