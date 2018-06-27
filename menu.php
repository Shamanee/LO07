<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="accueil.php" style="padding-left:25px;">Super-nounou.fr</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="accueil.php" >Accueil</a></li>
                <?php
                /**
                 * Menu modulable selon le type d'utilisateur qui se connecte au site
                 * Chaque type d'utilisateur aure un menu qui lui est propre
                 * Pour les nouonou en attente d'acceptation, elle ne pourra accéder à aucune fonctionnalité
                 */
                if ((isset($_SESSION['User_Type']))) {
                    if ($_SESSION['User_Type'] == 'nounou') {
                        echo "<li><a href='./tests/planning_test2.php'>Planning</a></li>\n";
                        echo "<li><a href='profil.php'>Profil</a></li>\n";
                        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='deconnexion.php' style='padding-right:25px;'><span class='glyphicon glyphicon-log-out'></span>Deconnexion</a></li>\n";
                    } else if ($_SESSION['User_Type'] == 'parent') {
                        echo "<li><a href='parent/demandeGarde.php'>Reserver</a></li>\n";
                        echo "<li><a href='parent/postGarde.php'>Post Garde</a></li>\n";
                        echo "<li><a href='enfant.php'>Enfants</a></li>\n";
                        echo "<li><a href='profil.php'>Profil</a></li>\n";
                        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='deconnexion.php' style='padding-right:25px;'><span class='glyphicon glyphicon-log-out'></span>Deconnexion</a></li>\n";
                    } else if ($_SESSION['User_Type'] == 'admin') {
                        echo "<li><a href='administration.php'>Administration</a></li>\n";
                        echo "<li><a href='profil.php'>Profil</a></li>\n";
                        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='deconnexion.php' style='padding-right:25px;'><span class='glyphicon glyphicon-log-out'></span>Deconnexion</a></li>\n";
                    } else if ($_SESSION['User_Type'] == 'pending') {
                        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='deconnexion.php' style='padding-right:25px;'><span class='glyphicon glyphicon-log-out'></span>Deconnexion</a></li>\n";
                        echo "<br/>\nVous etes en attente d'acceptation. Un administrateur s'occupe de vous.<br/>\n";
                    } else if ($_SESSION['User_Type'] == 'blocked') {
                        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='deconnexion.php' style='padding-right:25px;'><span class='glyphicon glyphicon-log-out'></span>Deconnexion</a></li>\n";
                        echo "<br/>\nVotre compte est temporairement bloqué.";
                    }
                } else {
                    echo "Veuillez vous connecter pour plus de fonctionnalités";
                }
                ?>
        </ul>
    </div>
</nav>