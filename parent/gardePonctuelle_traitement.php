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
$requete = $bdd->query("SELECT id FROM utilisateur WHERE User_Type='nounou' AND nom='" . $_POST["nounou"] . "'");
$result = $requete->fetch();
//var_dump($result);




$req = $bdd->prepare("INSERT INTO prestation (debut_datetime,fin_datetime,parent_id,nounou_id,type) VALUES (:debut_datetime, :fin_datetime, :parent_id, :nounou_id, :type)");
$req->execute(array(
    'debut_datetime' => $debut_datetime,
    'fin_datetime' => $fin_datetime,
    'parent_id' => $_SESSION['id'],
    'nounou_id' => $result['id'],
    'type' => 'ponctuelle',
));

//$requ= $bdd->query("SELECT id FROM prestation WHERE parent_id = ".$_SESSION['id']."");
//$resu = $requ->fetchAll();
//var_dump($resu);

echo "Les enfants sont :";
echo "<ul>";
$enf = array_unique($_POST['enfant']);
foreach ($enf as $k => $enfant) {
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
//echo $k + 1 . " enfants";
//
//echo "prix à payer : ";
//require './function_prix.php';
//calculPrix_ponctuelle($h_debut, $h_fin, $k+1);
//echo " &euro;";

?><a href="../accueil.php">Retour à l'accueil</a>
