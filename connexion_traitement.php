<?php
/**
 * On regarde si l'email fourni est dans la base de données.
 * Avec cet email, on va regarder le mot de passe associé et on vérifie si ce dernier est le meme que celui saisi
 */
require './bdd/connex_bdd.php';
$req=$bdd->prepare('SELECT id, nom, prenom, password, User_Type FROM utilisateur WHERE email = :email');
$req->execute(array(
    'email' => $_POST['email']));
$resultat = $req->fetch();

$isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

/**
 * S'il y a eu un problème dans l'envoie des informations de la base de données,
 * On affiche un message
 * Si le mot de passe est correct, on crée une session avec tous les renseignements nécessaire de la session
 * Sinon on indique à l'utilisateur que son identifiant est mauvais
 */
if(!$resultat){
    echo "Erreur dans la communication des données avec la DataBase";
    header('Refresh:2,url=connexion.php');
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
/**
 * Si une session a reussi a etre créée, on redirige l'utilisateur sur la page d'accueil
 */
if (isset($_SESSION['id'])){
    header("location: accueil.php");
    exit();
}
?>