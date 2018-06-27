<?php
//session_start();
require './bdd/connex_bdd.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2>Vos Evaluations</h2>

<table class="table table-bordered table-striped">
    <tr>
        <th>Note</th>
        <th>Commentaire</th>
        <th>Parent</th>
    </tr>
    <?php
    $nounouId = $_SESSION['id'];
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
