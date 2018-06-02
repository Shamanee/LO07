<ul>
    <li><a href="../accueil.php">Accueil</a></li>
    <?php
    /**
     * Menu modulable selon le type d'utilisateur qui se connecte au site
     * Chaque type d'utilisateur aure un menu qui lui est propre
     * Pour les nouonou en attente d'acceptation, elle ne pourra accéder à aucune fonctionnalité
     */
    if ((isset($_SESSION['User_Type']))) {
        if ($_SESSION['User_Type'] == 'nounou') {
            //echo "<li><a href='./planning_test2.php'>Planning</a></li>\n";
            echo "<li><a href='../profil.php'>Profil</a></li>\n";
            echo "<li><a href='../deconnexion.php'>Deconnexion</a></li>\n";
        }
    }
    ?>
</ul>