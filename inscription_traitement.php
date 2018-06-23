<?php

/**
 * On traite les données passées dans le formulaire d'inscription
 * Puis on ajoute les données à la Base de données
 * Et on redirige l'utilisateur vers l'écran de connexion pour qu'il puisse se connecter
 */
require './bdd/connex_bdd.php';
//Rajouter les if isset
/**
 * Comme les nounouns doivent etre validées avant de pouvoir etre inscrite, on les place en attente.
 * C'est pour cela que le type de la nounoun sera 'pending' a la place de 'nounou'
 */
if (isset($_POST['type'])) {
    if ($_POST['type'] == 'nounou') {
        $type = 'pending';
    } else {
        $type = $_POST['type'];
}
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$ville = $_POST['ville'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT); //Cette fonction php sert à hasher un mot de passe
//$pass=$_POST['password'];
$naissance = $_POST['naissance'];
$photo = '';
$experience = '';
$information = '';

/* echo $type.'<br/>';
  echo $nom.'<br/>';
  echo $prenom.'<br/>';
  echo $ville.'<br/>';
  echo $email.'<br/>';
  echo $pass.'<br/>';
  echo $naissance.'<br/>'; */

/* $requete=$bdd->prepare('INSERT INTO utilisateur(User_Type, password, email, nom, prenom, ville, photo, date_naissance, experience, information) VALUES (:type, :pass, :email, :nom, :prenom, :ville, :photo, :date_naissance, :experience, :information)');
  $requete->execute(array(
  'type' => $type,
  'pass' => $pass,
  'email' => $email,
  'nom' => $nom,
  'prenom' => $prenom,
  'ville' => $ville,
  'photo' => $photo,
  'date_naissance' => $naissance,
  'experience' => $experience,
  'information' => $information)); */
$bdd->exec("INSERT INTO utilisateur (User_Type, password, email, nom, prenom, ville, photo, date_naissance, experience, information) VALUES ('" . $type . "', '" . $pass . "', '" . $email . "', '" . $nom . "', '" . $prenom . "', '" . $ville . "', NULL, '" . $naissance . "', NULL, NULL);");
//$bdd->exec("INSERT INTO utilisateur (User_Type, password, email, nom, prenom, ville, photo, date_naissance, experience, information) VALUES ('a', 'a', 'a', 'a', 'a', 'a', NULL, 'a', NULL, NULL);");
////$bdd->exec("INSERT INTO utilisateur VALUES ('2', 'parent', 'testestes', 'testsets', 'azeazsdqs', 'qsdsqsq', 'azezae', NULL, '14/03/1998', NULL, NULL);");
//$bdd->exec("INSERT INTO langue VALUES ('1', 'francais');");
//echo "Utilisateur ajouté";
/* $req=$bdd->query('SELECT * FROM utilisateur');
  while($donnees=$req->fetch()){
  var_dump($donnees);
  }
  $req->closeCursor(); */
//if ($_POST['type'] === 'nounou') {
//    header('Location:dispo_form.php');
//} else {
    echo "Vous allez être redirigé vers la page de connexion";
    header('Refresh:2; url=connexion.php');
    }
    ?>

