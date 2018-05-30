<ul>
    <li><a href="accueil.php">Accueil</a></li>
    <?php
    /**
     * Menu modulable selon le type d'utilisateur qui se connecte au site
     * Chaque type d'utilisateur aure un menu qui lui est propre
     * Pour les nouonou en attente d'acceptation, elle ne pourra accéder à aucune fonctionnalité
     */
    if($_SESSION['User_Type']=='nounou'){
        echo "<li><a href='./tests/planning_test2.php'>Planning</a></li>\n";
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