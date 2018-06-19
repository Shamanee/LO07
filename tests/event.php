<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
/**
 * Page pour avoir les détail d'une Prestation
 * On passe directement dans l'url l'id de la prestation pour avoir les details de cette dernière
 * Si cette prestation n'est pas trouvée, on renvoie la page de l'erreur404
 */
require './debug.php';
require '../classe/Prestation.php';
require '../bdd/connex_bdd.php';

$pdo = get_pdo();
$events = new Prestation($pdo);
if (!isset($_GET['id'])) {
    header("location: error404.html");
}
try {
    $event = $events->find($_GET['id']);
} catch (Exception $ex) {
    e404();
}
require'./views/header.php';
?>

<h1>Garde numero <?= $event->getId(); ?></h1>
<?php
// ajouter le nom de l'enfant et de la nourrice dans la garde
$utilisateurId = $event->getParent_id();
$langueId = $event->getLangue_id();
$enfantId = $event->getEnfant_id();
$eventId = $event->getId();
$sql = "SELECT nom,prenom FROM utilisateur WHERE id = $utilisateurId";
$statement = $bdd->query($sql);
$res = $statement->fetchAll();
if (isset($langueId)) {
    $req = $bdd->query("SELECT Langue FROM Langue WHERE id = $langueId");
    $result = $req->fetch();
    //var_dump($result);
}
?>

<ul>
    <li>Date début: <?= $event->getDebut_datetime()->format('d/m/Y'); ?></li>
    <li>Heure début : <?= $event->getDebut_datetime()->format('H:i'); ?></li>
    <li>Date fin: <?= $event->getFin_datetime()->format('d/m/Y'); ?></li>
    <li>Heure fin : <?= $event->getFin_datetime()->format('H:i'); ?></li>
    <?php if (isset($result['Langue'])): ?>
        <li>Langue : <?= $result['Langue'] ?></li>
    <?php endif; ?>
    <li>Parent :
        <?=
        h($res['0']['nom'] . " " . $res['0']['prenom']);
        //ajouter les descriptions liées à l'enfant
        ?>
    </li>
    <li>Enfants :
        <ul>


            <?php
            $reqq = $bdd->query("SELECT E.prenom FROM enfant E, prestation P, prestation_has_enfant Z WHERE P.id=$eventId AND P.id=Z.prestation_id AND Z.enfant_utilisateur_id=$utilisateurId AND Z.enfant_utilisateur_id=P.parent_id AND E.id=Z.enfant_id");
            while ($ress = $reqq->fetch()) {
                echo "<li>" . $ress['prenom'] . "</li>";
            }
            ?>
        </ul>
    </li>
</ul>

<?php require './views/footer.php'; ?>