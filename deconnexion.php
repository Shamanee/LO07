<?php
/**
 * On remplace les données de la session précédemment créée par un tableau vide
 * Puis on détruit la session
 * Et on redirige l'utilisateur vers l'écran de connexion
 */
session_start();
$_SESSION = array();
session_destroy();
header("location: connexion.php");
?>

