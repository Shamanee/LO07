<?php

session_start();
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
require '../bdd/connex_bdd.php';

$h_debut = $_POST["heure_debut"];
$h_fin = $_POST["heure_fin"];

$date = date_create($_POST['date']);

$debut_datetime = $date->format("Y-m-d {$h_debut}:s");
$fin_datetime = $date->format("Y-m-d {$h_fin}:s");
var_dump($debut_datetime);
var_dump($fin_datetime);

echo "Vous avez choisi la nounou suivante pour le " . $_POST['date'] . " : ";
echo $_POST["nounou"] . "<br/>\n";
$requete = $bdd->query("SELECT id FROM utilisateur WHERE User_Type='nounou' AND nom='" . $_POST["nounou"] . "'");
$result = $requete->fetch();
var_dump($result);
$req = $bdd->prepare("INSERT INTO prestation (debut_datetime,fin_datetime,parent_id,nounou_id) VALUES (:debut_datetime, :fin_datetime, :parent_id, :nounou_id)");
$req->execute(array(
    'debut_datetime' => $debut_datetime,
    'fin_datetime' => $fin_datetime,
    'parent_id' => $_SESSION['id'],
    'nounou_id' => $result['id'],
));
