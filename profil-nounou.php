<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php 
session_start();
require './bdd/connex_bdd.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
         require './menu.php';
        $photoprofil = $bdd->prepare('SELECT photo FROM utilisateur WHERE nom=:nom AND User_Type="nounou"');
        $photoprofil->execute(array('nom' => $_GET['nom']));

        while ($donnees = $photoprofil->fetch()) {
            var_dump($donnees);
            if (isset($donnees['photo'])) {
                echo "<img src='" . $donnees['photo'] . "' name='photo_profil' alt='Photo de profil' height='100px'/><br/>\n";
            } else {
                echo "<img src='photo/blank_photo' name='photo_profil' alt='Photo de profil' height='100px'/><br/>\n";
            }
        }
        $photoprofil->closeCursor();
        
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
            <table>
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
            <br/>   
            <?php
        }
        $req = $bdd->query("SELECT COUNT(langue_id) FROM utilisateur_has_langue WHERE utilisateur_id='" . $res['id'] . "'");
        $resultat = $req->fetchAll();
        if ($resultat[0] !== '0') {
            ?>
            <table>
                <tr>
                    <th>Langues parlées</th>
                </tr>
                <?php
                $statement = $bdd->query("SELECT L.Langue FROM utilisateur_has_langue U, langue L WHERE U.utilisateur_id = '" . $res['id'] . "' AND U.langue_id = L.id");
                while ($don = $statement->fetch()) {
                    //var_dump($don);
                    echo "<tr>\n<td>" . $don['Langue'] . "</td>\n</tr>\n";
                }
                ?>
            </table>

            <?php
        }
        if($_SESSION['User_Type']==='admin'):
        ?>
        <h2>Les bénéfices</h2>
        <h3>Mensuel : </h3><?= calculBenefNounouMois($res['id']) ?>&euro;<br/>
        <h3>Hebdomadaire :</h3><?= calculBenefNounouSemaine($res['id']) ?>&euro;<br/>
        <?php endif; ?>
        
        <h2>Les Evaluations</h2>

        <table>
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

    </body>
</html>
