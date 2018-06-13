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

echo "Vous avez choisi la nounou suivante pour le " . $_POST['date'] . " : ";
echo $_POST["nounou"] . "<br/>\n";
echo "La garde sera en ".$_POST['langue'].".";

$requete = $bdd->query("SELECT U.id FROM utilisateur U, langue L, utilisateur_has_langue Z WHERE U.User_Type='nounou' AND U.nom='" . $_POST["nounou"] . "' AND Z.utilisateur_id=U.id AND L.Langue='".$_POST['langue']."' AND Z.langue_id=L.id");
$result = $requete->fetch();
var_dump($result);
$requete1 = $bdd->query("SELECT L.id FROM utilisateur U, langue L, utilisateur_has_langue Z WHERE U.User_Type='nounou' AND U.nom='" . $_POST["nounou"] . "' AND Z.utilisateur_id=U.id AND L.Langue='".$_POST['langue']."' AND Z.langue_id=L.id");
$result1 = $requete1->fetch();

$req = $bdd->prepare("INSERT INTO prestation (debut_datetime,fin_datetime,parent_id,nounou_id,langue_id) VALUES (:debut_datetime, :fin_datetime, :parent_id, :nounou_id, :langue_id)");
$req->execute(array(
    'debut_datetime' => $debut_datetime,
    'fin_datetime' => $fin_datetime,
    'parent_id' => $_SESSION['id'],
    'nounou_id' => $result['id'],
    'langue_id' => $result1['id']
));
var_dump($req);

