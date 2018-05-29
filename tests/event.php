<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require './debug.php';
require '../classe/Prestation.php';
require '../bdd/connex_bdd.php';

$pdo = get_pdo();
$events = new Prestation($pdo);
if (!isset($_GET['id'])) {
    header("location: error404.html");
}
try{
    $event = $events->find($_GET['id']);
} catch (Exception $ex) {
    e404();
}
require'./views/header.php';
?>

<h1>Garde numero <?= $event->getId();?></h1>
<?php // ajouter le nom de l'enfant et de la nourrice dans la garde
    $utilisateurId = $event->getUtilisateur_id();
    $sql = "SELECT nom,prenom FROM utilisateur WHERE id = $utilisateurId";
    $statement = $bdd->query($sql);
    $res = $statement->fetchAll();?>
<ul>
    <li>Date début: <?= $event->getDebut_datetime()->format('d/m/Y');?></li>
    <li>Heure début : <?= $event->getDebut_datetime()->format('H:i');?></li>
    <li>Date fin: <?= $event->getFin_datetime()->format('d/m/Y');?></li>
    <li>Heure fin : <?= $event->getFin_datetime()->format('H:i');?></li>
    <li>Parent :
        <?= h($res['0']['nom'] . " " . $res['0']['prenom']);
        //ajouter les descriptions liées à l'enfant
        ?>
    </li>
</ul>

<?php require './views/footer.php'; ?>