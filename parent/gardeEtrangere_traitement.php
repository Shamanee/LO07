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
//var_dump($debut_datetime);
//var_dump($fin_datetime);

echo "Vous avez choisi la nounou suivante pour le " . $_POST['date'] . " : ";
echo $_POST["nounou"] . "<br/>\n";
echo "La garde sera en ".$_POST['langue'].".";

$requete = $bdd->query("SELECT U.id FROM utilisateur U, langue L, utilisateur_has_langue Z WHERE U.User_Type='nounou' AND U.nom='" . $_POST["nounou"] . "' AND Z.utilisateur_id=U.id AND L.Langue='".$_POST['langue']."' AND Z.langue_id=L.id");
$result = $requete->fetch();
//var_dump($result);
$requete1 = $bdd->query("SELECT L.id FROM utilisateur U, langue L, utilisateur_has_langue Z WHERE U.User_Type='nounou' AND U.nom='" . $_POST["nounou"] . "' AND Z.utilisateur_id=U.id AND L.Langue='".$_POST['langue']."' AND Z.langue_id=L.id");
$result1 = $requete1->fetch();

$req = $bdd->prepare("INSERT INTO prestation (debut_datetime,fin_datetime,parent_id,nounou_id,langue_id,type) VALUES (:debut_datetime, :fin_datetime, :parent_id, :nounou_id, :langue_id, :type)");
$req->execute(array(
    'debut_datetime' => $debut_datetime,
    'fin_datetime' => $fin_datetime,
    'parent_id' => $_SESSION['id'],
    'nounou_id' => $result['id'],
    'langue_id' => $result1['id'],
    'type' => 'etrangere',
));
//var_dump($req);

echo "Les enfants sont :";
echo "<ul>";

$enf = array_unique($_POST['enfant']);
foreach ($enf as $k => $enfant) {
    //var_dump($enfant);
    echo "<li>$enfant</li>";
    $reeq = $bdd->query("SELECT E.id AS id_enfant, P.id from enfant E, prestation P WHERE E.Prenom='" . $enfant . "' AND E.utilisateur_id=" . $_SESSION['id'] . " AND P.parent_id = ".$_SESSION['id']." AND P.debut_datetime='$debut_datetime' AND P.fin_datetime='$fin_datetime'");
    while($rees = $reeq->fetch()){
    //var_dump($rees);
    $request = $bdd->prepare("INSERT INTO prestation_has_enfant (prestation_id, enfant_id,enfant_utilisateur_id) VALUES (:prestation_id, :enfant_id, :enfant_utilisateur_id)");
    $request->execute(array(
    'prestation_id' => $rees['id'],
    'enfant_id' => $rees['id_enfant'],
    'enfant_utilisateur_id' => $_SESSION['id'],
    ));
    }
}
echo"</ul>";
?>
<a href="../accueil.php">Retour à l'accueil</a>

