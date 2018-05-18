<?php
$user='root';
$password='';
$dataSourceName='mysql:host=localhost;dbname=projetlo07db';

try{
    $bdd=new PDO($dataSourceName, $user, $password);
} catch (Exception $ex) {
    die ("Erreur ! " . $ex->getMessage());
}    
?>


