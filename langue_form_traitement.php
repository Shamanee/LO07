<?php
session_start();
require './bdd/connex_bdd.php';
var_dump($_POST);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$nb_langue = count($_POST['langue']);
for ($i = 0; $i < $nb_langue; $i++) {
    //var_dump($_POST['langue'][$i]);
    $sql = "SELECT id FROM langue WHERE Langue = '" . $_POST['langue'][$i] . "'";
    $res=$bdd->query($sql);
    while($donnees = $res->fetch()){
        //var_dump($donnees);
        $req=$bdd->exec("INSERT INTO utilisateur_has_langue (utilisateur_id,langue_id) VALUES (".$_SESSION['id'].",".$donnees['id'].")");
        
    }
}
echo 'Vos langues ont été enregistrés, vous allez être redirigé';
header('Location:accueil.php');

?>