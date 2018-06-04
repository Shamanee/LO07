<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
/**
 * Page de profil d'un utilisateur ou il pourra voir des détails sur lui
 * Accéder a la modification de son profil
 * Pour une nounou, elle pourra consulter les heures effectuées durant une période ainsi que son revenu (A FAIRE)
 */
session_start();
require './bdd/connex_bdd.php';
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
        /**
         * On vérifie le type d'utilisateur, si ce n'est pas un utilisateur renseigné/connecté, on lui indique une erreur403 avec un acces interdit a la page
         */
        if ($_SESSION['User_Type'] == 'parent') {
            echo"<h1>PARENT</h1>\n";
            echo $_SESSION['prenom'] . " " . $_SESSION['nom'] . "<br/>\n";
            echo "\n";
        } else if ($_SESSION['User_Type'] == 'nounou') {
            echo"<h1>NOUNOU</h1>\n";
        } else if ($_SESSION['id'] == 1) {
            echo"<h1>ADMIN</h1>\n";
            echo"vous avez beaucoup de droits<br/>\n";
        } else {
            header('location: error403.html');
        }
        ?>
        <?php
        /**
         * On charge la photo de profil de l'utilisateur
         * Si celui-ci n'en a pas, une photo de profil par défaut est mise en place
         */
        $photoprofil = $bdd->prepare('SELECT photo FROM utilisateur WHERE id=:id');
        $photoprofil->execute(array('id' => $_SESSION['id']));

        while ($donnees = $photoprofil->fetch()) {
            if (isset($donnees['photo'])) {
                echo "<img src='" . $donnees['photo'] . "' name='photo_profil' alt='Photo de profil' height='100px'/><br/>\n";
            } else {
                echo "<img src='photo/blank_photo' name='photo_profil' alt='Photo de profil' height='100px'/><br/>\n";
            }
        }
        $photoprofil->closeCursor();
        ?>
        <a href='modification_profil.php'>Modifier Profil</a><br/>
        <?php
        if ($_SESSION['User_Type'] === 'nounou') {
            echo "<a href='dispo_form.php'>Changer vos disponibilités</a><br/>";
        }
        ?>
        <a href="accueil.php">Retour</a>



        <?php
        if ($_SESSION['User_Type'] === 'nounou') {
            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            $re = $bdd->query("SELECT COUNT(jour) FROM disponibilite WHERE utilisateur_id='" . $_SESSION['id'] . "'");
            $res = $re->fetchAll();
            var_dump($res);
            if ($res[0] !== '0') {
                ?>
                <h2>Vos disponibilités (Générales)</h2>
                <table>
                    <tr>
                        <th></th>
                        <th>Heure début</th>
                        <th>Heure fin</th>
                    </tr>
                    <?php
                    foreach ($jours as $k => $jour) {
                        $r = $bdd->query("SELECT Debut,Fin FROM disponibilite WHERE utilisateur_id='" . $_SESSION['id'] . "' AND jour=$k");
                        $result = $r->fetch();
                        echo "<tr>\n<th>$jour</th>\n<td>" . $result['Debut'] . "</td>\n<td>" . $result['Fin'] . "</td>\n</tr>\n";
                    }
                    ?>
                </table>
                <br/>   
                <?php
            }
            $req = $bdd->query("SELECT COUNT(langue_id) FROM utilisateur_has_langue WHERE utilisateur_id='" . $_SESSION['id'] . "'");
            $resultat = $req->fetchAll();
            if ($resultat[0] !== '0') {
                ?>
                <table>
                    <tr>
                        <th>Langues parlées</th>
                    </tr>
                    <?php
                    $statement=$bdd->query("SELECT L.Langue FROM utilisateur_has_langue U, langue L WHERE U.utilisateur_id = '".$_SESSION['id']."' AND U.langue_id = L.id");
                    while ($don=$statement->fetch()){
                        //var_dump($don);
                        echo "<tr>\n<td>".$don['Langue']."</td>\n</tr>\n";
                    }
                    ?>
                </table>

            <?php
            }
        }
        ?>
    </body>
</html>
