<?php

session_start();
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
require '../bdd/connex_bdd.php';
var_dump($_POST);
$jours = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
$d = new DateTime('now');
$datemax = date_create($_POST['datemax']);
var_dump($datemax);
$datetime = new DateTime('now');
do{
    $d = $d->modify("+ 7 days");
    foreach ($jours as $k => $jour) {
        $date = $datetime->modify("next $jour");
        if (isset($_POST["nounou_$k"])) {
            //var_dump($_POST["nounou_" . $k . ""]);
            $h_debut = $_POST["heure_debut_$k"];
            $h_fin = $_POST["heure_fin_$k"];

            $debut_datetime = $date->format("Y-m-d {$h_debut}:s");
            $fin_datetime = $date->format("Y-m-d {$h_fin}:s");

            //var_dump($debut_datetime);
            //var_dump($fin_datetime);
            echo "Vous avez choisi la nounou suivante pour le $jour: ";
            echo $_POST["nounou_$k"] . "<br/>\n";
            //var_dump($_SESSION['id']);
            $requete = $bdd->query("SELECT id FROM utilisateur WHERE User_Type='nounou' AND nom='".$_POST["nounou_$k"]."'");
            $result = $requete->fetch();
            var_dump($result);
        $req = $bdd->prepare("INSERT INTO prestation (debut_datetime,fin_datetime,parent_id,nounou_id) VALUES (:debut_datetime, :fin_datetime, :parent_id, :nounou_id)");
        $req->execute(array(
            'debut_datetime' => $debut_datetime,
            'fin_datetime' => $fin_datetime,
            'parent_id' => $_SESSION['id'],
            'nounou_id' => $result['id'],
        ));
        }
    }

    
    //var_dump($d);
    //var_dump($date);
}while ($d < $datemax->modify("last sunday"));
