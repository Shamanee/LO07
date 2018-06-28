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
        <meta author="Timothée Drouot, Thomas Conroux">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <section class="presentation">
            <div class="nomprofil container-fluid text-center bg-2">
                <?php
                include './menu.php';
                ?>

                <?php
                /**
                 * On vérifie le type d'utilisateur, si ce n'est pas un utilisateur renseigné/connecté, on lui indique une erreur403 avec un acces interdit a la page
                 */
                if ($_SESSION['User_Type'] == 'parent') {
                    echo"<h1>PARENT - ";
                    echo $_SESSION['prenom'] . " " . $_SESSION['nom'] . "</h1><br/>\n";
                    echo "\n";
                } else if ($_SESSION['User_Type'] == 'nounou') {
                    echo"<h1>NOUNOU - " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . "</h1>\n";
                } else if ($_SESSION['id'] == 1) {
                    echo"<h1>ADMIN</h1>\n";
                } else {
                    header('location: error403.html');
                }
                ?>
            </div>
            <div class="bg-2 text-center photoprofil">

                <?php
                /**
                 * On charge la photo de profil de l'utilisateur
                 * Si celui-ci n'en a pas, une photo de profil par défaut est mise en place
                 */
                $photoprofil = $bdd->prepare('SELECT photo FROM utilisateur WHERE id=:id');
                $photoprofil->execute(array('id' => $_SESSION['id']));

                while ($donnees = $photoprofil->fetch()) {
                    if (isset($donnees['photo'])) {
                        echo "<img src='" . $donnees['photo'] . "' name='photo_profil' alt='Photo de profil' height='100px' class='thumbnail' style='margin-left: auto; margin-right: auto;'/><br/>\n";
                    } else {
                        echo "<img src='photo/blank_photo' name='photo_profil' alt='Photo de profil' height='100px' class='rounded'/><br/>\n";
                    }
                }
                $photoprofil->closeCursor();
                ?>
                <a href='modification_profil.php'>Modifier Profil</a> - 
                <?php
                if ($_SESSION['User_Type'] === 'nounou') {
                    echo "<a href='dispo_form.php'>Changer vos disponibilités</a> - ";
                }
                ?>
                <a href="accueil.php">Retour</a>
            </div>

        </section>


        <section class="nounou_donnees">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="col-md-6 benef">
                        <div class="">
                        <?php
                        if ($_SESSION['User_Type'] === 'nounou') {
                            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                            $re = $bdd->query("SELECT COUNT(jour) FROM disponibilite WHERE utilisateur_id='" . $_SESSION['id'] . "'");
                            $res = $re->fetchAll();
                            //var_dump($res);
                            require './administration/function.php';
                            ?>
                            <h2>Vos bénéfices</h2>
                            <h3>Mensuel : </h3><?= calculBenefNounouMois($_SESSION['id']) ?>&euro;<br/>
                            <h3>Hebdomadaire :</h3><?= calculBenefNounouSemaine($_SESSION['id']) ?>&euro;<br/>
                        </div>
                        </div>
                        <?php
                        if ($res[0] !== '0') {
                            ?>
                            <div class="col-md-6 dispo">
                                <h2>Vos disponibilités (Générales)</h2>
                                <table class="table table-bordered table-striped">
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
                            </div>
                        </div>
                        <?php
                    }
                    $req = $bdd->query("SELECT COUNT(langue_id) FROM utilisateur_has_langue WHERE utilisateur_id='" . $_SESSION['id'] . "'");
                    $resultat = $req->fetchAll();
                    if ($resultat[0] !== '0') {
                        ?>
                        <div class="col-md-12">
                            <div class="langue col-md-6">
                                <h2>Langues parlées</h2>
                                <ul>
                                    <?php
                                    $statement = $bdd->query("SELECT L.Langue FROM utilisateur_has_langue U, langue L WHERE U.utilisateur_id = '" . $_SESSION['id'] . "' AND U.langue_id = L.id");
                                    while ($don = $statement->fetch()) {
                                        //var_dump($don);
                                        echo "<li>" . $don['Langue'] . "</li>\n";
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="evaluation col-md-6">
                                <?php
                            }
                            require './evaluation.php';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <?php require './footer.html';?>
</body>
</html>
