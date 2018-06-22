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
var_dump($_SESSION['id']);
require('../bdd/connex_bdd.php');
require('./functionform.php');
$date = new DateTime('now');
$dateToday = $date->format("Y-m-d H:i");
$note = [0, 1, 2, 3, 4, 5];
var_dump($dateToday);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        Vos gardes précédentes
        <br/>
        <br/>
        <table>
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
                var_dump($resultat);
                $requete = $bdd->query("SELECT Note FROM evaluation WHERE nounou_id=" . $resultat['nounou_id'] . " AND parent_id=" . $_SESSION['id'] . " AND prestation_id=" . $resultat['id'] . "");
                $result = $requete->fetch();
                var_dump($result);
                ?>
                <tr>
                    <td><?= $resultat['debut_datetime'] ?></td>
                    <td><?= $resultat['nom'] ?></td>
                    <?php if (empty($result)) { ?>
                        <td>
                            <form method="POST" action="evaluation_traitement.php">
                                <?php radio("note_$k", $note); ?><br/>
                                <textarea name="commentaire_<?= $k ?>" cols="35" rows="4"></textarea><br/>
                                <input type="hidden" name="prestation_id_<?=$k?>" value="<?=$resultat['id']?>"/>
                                <input type="hidden" name="nounou_id_<?=$k?>" value="<?=$resultat['nounou_id']?>"/>
                                <input type="submit" name='submit_<?= $k ?>' value="Noter"/>
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
    </body>
</html>
