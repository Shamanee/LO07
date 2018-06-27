<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="../accueil.php" style="padding-left:25px;">Super-nounou.fr</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="../accueil.php" >Accueil</a></li>
                <?php
                //session_start();
                if ((isset($_SESSION['User_Type']))) {
                    if ($_SESSION['User_Type'] == 'parent') {
                        echo "<li><a href='demandeGarde.php'>Reserver</a></li>\n";
                        echo "<li><a href='postGarde.php'>Post Garde</a></li>\n";
                        echo "<li><a href='../enfant.php'>Enfants</a></li>\n";
                        echo "<li><a href='../profil.php'>Profil</a></li>\n";
                        echo "</ul><ul class='nav navbar-nav navbar-right'><li><a href='../deconnexion.php' style='padding-right:25px;'><span class='glyphicon glyphicon-log-out'></span>Deconnexion</a></li>\n";
                    }
                }
                ?>
        </ul>
    </div>
</nav>