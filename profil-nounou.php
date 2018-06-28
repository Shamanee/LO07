<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start();
require './bdd/connex_bdd.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
            <div class="container-fluid nomprofil text-center bg-2">
                <?php require './menu.php'; ?>

                <h1>NOUNOU - <?= $_GET['nom'] ?></h1>
            </div>
            <div class="bg-2 text-center photoprofil">
                <?php
                $photoprofil = $bdd->prepare('SELECT photo FROM utilisateur WHERE nom=:nom AND User_Type="nounou"');
                $photoprofil->execute(array('nom' => $_GET['nom']));

                while ($donnees = $photoprofil->fetch()) {
                    //var_dump($donnees);
                    if (isset($donnees['photo'])) {
                        echo "<img src='" . $donnees['photo'] . "' class='thumbnail' name='photo_profil' alt='Photo de profil' height='100px' style='margin-left: auto; margin-right: auto;'/><br/>\n";
                    } else {
                        echo "<img src='photo/blank_photo' name='photo_profil' alt='Photo de profil' height='100px'/><br/>\n";
                    }
                }
                $photoprofil->closeCursor();
                ?>
            </div>
        </section>
        <section class="nounou_donnees">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6 dispo">
                            <?php
                            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                            $re = $bdd->query("SELECT COUNT(D.jour), U.id FROM disponibilite D, utilisateur U WHERE U.nom ='" . $_GET['nom'] . "' AND D.utilisateur_id=U.id");
                            $res = $re->fetch();
                            //var_dump($res);
                            require './administration/function.php';
                            ?>

                            <?php
                            if ($res !== '0') {
                                ?>
                                <h2>Les disponibilités (Générales)</h2>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th></th>
                                        <th>Heure début</th>
                                        <th>Heure fin</th>
                                    </tr>
                                    <?php
                                    foreach ($jours as $k => $jour) {
                                        $r = $bdd->query("SELECT Debut,Fin FROM disponibilite WHERE utilisateur_id='" . $res['id'] . "' AND jour=$k");
                                        $result = $r->fetch();
                                        echo "<tr>\n<th>$jour</th>\n<td>" . $result['Debut'] . "</td>\n<td>" . $result['Fin'] . "</td>\n</tr>\n";
                                    }
                                    ?>
                                </table>
                            </div>
                            <br/> 
                            <div class="langue col-md-6">
                                <?php
                            }
                            $req = $bdd->query("SELECT COUNT(langue_id) FROM utilisateur_has_langue WHERE utilisateur_id='" . $res['id'] . "'");
                            $resultat = $req->fetchAll();
                            if ($resultat[0] !== '0') {
                                ?>
                                <h2>Langues parlées</h2>
                                <ul>
                                    <?php
                                    $statement = $bdd->query("SELECT L.Langue FROM utilisateur_has_langue U, langue L WHERE U.utilisateur_id = '" . $res['id'] . "' AND U.langue_id = L.id");
                                    while ($don = $statement->fetch()) {
                                        //var_dump($don);
                                        echo "<li>" . $don['Langue'] . "</li>\n";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                    if ($_SESSION['User_Type'] === 'admin'):
                        ?>
                        <div class="col-md-12">
                            <div class="benef col-md-6">
                                <h2>Les bénéfices</h2>
                                <h3>Mensuel : </h3><?= calculBenefNounouMois($res['id']) ?>&euro;<br/>
                                <h3>Hebdomadaire :</h3><?= calculBenefNounouSemaine($res['id']) ?>&euro;<br/>
                            <?php endif; ?>
                        </div>
                        <div class="evaluation col-md-6">
                            <h2>Les Evaluations</h2>

                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Note</th>
                                    <th>Commentaire</th>
                                    <th>Parent</th>
                                </tr>
                                <?php
                                $nounouId = $res['id'];
                                $sql = "SELECT E.Note, E.Commentaire, U.nom FROM evaluation E, utilisateur U WHERE nounou_id=$nounouId AND E.parent_id=U.id";
                                //$sql = "SELECT Note, Commentaire FROM evaluation WHERE nounou_id=$nounouId";
                                $req = $bdd->query($sql);
                                while ($donnees = $req->fetch()):
                                    ?>
                                    <tr>
                                        <td><?php
                                            switch ($donnees['Note']) {
                                                case 0:
                                                    echo '';
                                                    break;
                                                case 1:
                                                    echo '*';
                                                    break;
                                                case 2:
                                                    echo '**';
                                                    break;
                                                case 3:
                                                    echo'***';
                                                    break;
                                                case 4:
                                                    echo'****';
                                                    break;
                                                case 5:
                                                    echo '*****';
                                                    break;
                                                default :
                                                    echo '';
                                            }
                                            ?></td>

                                        <td><?= $donnees['Commentaire'] ?></td>
                                        <td><?= $donnees['nom'] ?></td>
                                    </tr>
                                    <?php
                                endwhile;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <?php require 'footer.html'?>
</body>
</html>
