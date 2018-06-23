<ul>
    <li><a href="../accueil.php">Accueil</a></li>
    <?php
    //session_start();
    if ((isset($_SESSION['User_Type']))) {
        if ($_SESSION['User_Type'] == 'parent') {
            echo "<li><a href='demandeGarde.php'>Reserver</a></li>\n";
            echo "<li><a href='postGarde.php'>Post Garde</a></li>\n";
            echo "<li><a href='../enfant.php'>Enfants</a></li>\n";
            echo "<li><a href='../profil.php'>Profil</a></li>\n";
            echo "<li><a href='../deconnexion.php'>Deconnexion</a></li>\n";
        }
    }
    ?>
</ul>