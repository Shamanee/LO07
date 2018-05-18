<?php
require './connex_bdd.php';
session_start();
$prenom=$_POST['prenom'];
$date_naissance=$_POST['date_naissance'];
$bdd->exec("INSERT INTO enfant (Prenom, Date_Naissance, utilisateur_id) VALUES ('".$prenom."', '".$date_naissance."','".$_SESSION['id']."');");
header('location: enfant.php');

?>

