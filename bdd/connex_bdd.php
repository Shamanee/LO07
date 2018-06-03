<?php
/**
 * Fichier de connexion a la base de données
 * Contient le nom d'utilisateur de phpMyAdmin
 *              mot de passe de phpMyAdmin
 *              Nom de la base de donnée sur phpMyAdmin
 * Et on se connecte à la base de données.
 * Si cela ne marche pas, on affiche une erreur à l'utilisateur
 */
$user='root';
$password='';
$dataSourceName='mysql:host=localhost;dbname=projetlo07db';

try{
    $bdd=new PDO($dataSourceName, $user, $password,[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $ex) {
    die ("Erreur ! " . $ex->getMessage());
}    
?>


