<?php
require './bdd/connex_bdd.php';
$req=$bdd->prepare('SELECT id, nom, prenom, password, User_Type FROM utilisateur WHERE email = :email');
$req->execute(array(
    'email' => $_POST['email']));
$resultat = $req->fetch();

$isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
var_dump($_POST['password']);
var_dump($resultat['password']);
var_dump($isPasswordCorrect);

if(!$resultat){
    echo "Oui, ca marche pas";
}else{
    if($isPasswordCorrect){
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['mail'] = $_POST['email'];
        $_SESSION['nom'] = $resultat['nom'];
        $_SESSION['prenom'] = $resultat['prenom'];
        $_SESSION['User_Type'] = $resultat['User_Type'];
        echo "Vous êtes connecté !";
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}


$req->closeCursor();

if (isset($_SESSION['id'])){
    header("location: accueil.php");
    exit();
}
?>