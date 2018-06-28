<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
//var_dump($_SESSION['id']);
require('../bdd/connex_bdd.php');
require('./functionform.php');
$date = new DateTime('now');
$dateToday = $date->format("Y-m-d H:i");
$note = [0, 1, 2, 3, 4, 5];
//var_dump($dateToday);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta author="Timothée Drouot, Thomas Conroux">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <?php require './menu_parent.php'; ?>
        <div class="container">
            <div class="row">
        <h2>Vos gardes précédentes</h2>
        <p>
            Vous pouvez voir la liste des différentes gardes qui ont déjà été effectuées.
            Vous pouvez aussi laisser un avis sur ces gardes en les notant et en laissant
            un commentaire pour la nounou. Ces commentaires seront visibles sur les profils
            des nounous concernées.
        </p>
        <br/>
        <br/>
        <table class="table">
            <tr>
                <th>Date</th>
                <th>Nom Nounou</th>
                <th>Evaluation</th>
            </tr>
            <?php
            $req = $bdd->query("SELECT P.id, P.debut_datetime, P.nounou_id, U.nom FROM prestation P, utilisateur U WHERE P.parent_id=" . $_SESSION['id'] . " AND P.nounou_id=U.id AND P.debut_datetime<='$dateToday'");
            $res = $req->fetchAll();
            //var_dump($res);
            foreach ($res as $k => $resultat):
                //var_dump($resultat);
                $requete = $bdd->query("SELECT Note FROM evaluation WHERE nounou_id=" . $resultat['nounou_id'] . " AND parent_id=" . $_SESSION['id'] . " AND prestation_id=" . $resultat['id'] . "");
                $result = $requete->fetch();
                //var_dump($result);
                ?>
                <tr>
                    <td><?= $resultat['debut_datetime'] ?></td>
                    <td><?= $resultat['nom'] ?></td>
                    <?php if (empty($result)) { ?>
                        <td>
                            <form method="POST" action="evaluation_traitement.php">
                                <?php radio("note_$k", $note); ?><br/>
                                <div class="form-group">
                                    <label for="comment_<?=$k?>">Commentaire :</label>
                                    <textarea name="commentaire_<?= $k ?>" class="form-control" cols="35" rows="4" id="comment_<?=$k?>"></textarea><br/>
                                </div>
                                <input type="hidden" name="prestation_id_<?=$k?>" value="<?=$resultat['id']?>"/>
                                <input type="hidden" name="nounou_id_<?=$k?>" value="<?=$resultat['nounou_id']?>"/>
                                <input type="submit" name='submit_<?= $k ?>' class="btn btn-primary" value="Noter"/>
                            </form>
                        </td>
                        <?php
                    } else {
                        echo "<td>";
                        switch ($result['Note']) {
                            case 0 :
                                echo " ";
                                break;
                            case 1 :
                                echo "*";
                                break;
                            case 2 :
                                echo "**";
                                break;
                            case 3 :
                                echo "***";
                                break;
                            case 4 :
                                echo "****";
                                break;
                            case 5 :
                                echo "*****";
                                break;
                        }
                        echo "</td>";
                    }
                    ?>
                </tr>

            <?php endforeach; ?>

        </table>
            </div>
        </div>
        <?php require '../footer.html';?>
    </body>
</html>
