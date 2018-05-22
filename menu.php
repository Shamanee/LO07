<ul>
    <li><a href="accueil.php">Accueil</a></li>
    <?php
    if($_SESSION['User_Type']=='nounou'){
        echo "<li><a href='planning.php'>Planning</a></li>\n";
    }
    if($_SESSION['User_Type']=='parent'){
        echo "<li><a href=''>Reserver</a></li>\n";
        echo "<li><a href='enfant.php'>Enfants</a></li>\n";
    }
    ?>
    <li><a href="profil.php">Profil</a></li>
    <li><a href="deconnexion.php">Deconnexion</a></li>
</ul>