<ul>
    <li><a href="accueil.php">Accueil</a></li>
    <?php
    if($_SESSION['User_Type']=='nounou'){
        echo "<li><a href='planning.php'>Planning</a></li>\n";
        echo "<li><a href='profil.php'>Profil</a></li>\n";
        echo "<li><a href='deconnexion.php'>Deconnexion</a></li>\n";
    }
    else if($_SESSION['User_Type']=='parent'){
        echo "<li><a href=''>Reserver</a></li>\n";
        echo "<li><a href='enfant.php'>Enfants</a></li>\n";
        echo "<li><a href='profil.php'>Profil</a></li>\n";
        echo "<li><a href='deconnexion.php'>Deconnexion</a></li>\n";
    }else if($_SESSION['User_Type']=='admin'){
        echo "<li><a href='administration.php'>Administration</a></li>\n";
        echo "<li><a href='profil.php'>Profil</a></li>\n";
        echo "<li><a href='deconnexion.php'>Deconnexion</a></li>\n";
    }else if($_SESSION['User_Type']=='pending'){
        echo "<li><a href='deconnexion.php'>Deconnexion</a></li>\n";
        echo "<br/>\nVous etes en attente d'acceptation. Un administrateur s'occupe de vous.<br/>\n";
    }
    ?>
</ul>