<?php
/**
 * On ajoute les enfants dans la base de données les enfants ajoutés à l'aide du formulaire
 * Puis on redirige l'utilisateur sur la page enfant.php
 */
require './bdd/connex_bdd.php';
session_start();
$prenom=$_POST['prenom'];
$date_naissance=$_POST['date_naissance'];
$bdd->exec("INSERT INTO enfant (Prenom, Date_Naissance, utilisateur_id) VALUES ('".$prenom."', '".$date_naissance."','".$_SESSION['id']."');");
header('location: enfant.php');

?>

