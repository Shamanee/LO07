<?php
session_start();
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
require '../bdd/connex_bdd.php';
var_dump($_POST);
$jours = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
$d = new DateTime('now');
$d = $d->format("Y-m-d");
while ($d < $_POST['datemax']):
    foreach ($jours as $k => $jour) {
        if (isset($_POST["nounou_$k"])) {
            //var_dump($_POST["nounou_" . $k . ""]);
            $h_debut = $_POST["heure_debut_$k"];
            $h_fin = $_POST["heure_fin_$k"];

            $datetime = new DateTime('now');
            $date = $datetime->modify("next $jour");

            $debut_datetime = $date->format("Y-m-d {$h_debut}:s");
            $fin_datetime = $date->format("Y-m-d {$h_fin}:s");

            //var_dump($debut_datetime);
            //var_dump($fin_datetime);
            echo "Vous avez choisi la nounou suivante pour le $jour: ";
            echo $_POST["nounou_$k"] . "<br/>\n";
            //var_dump($_SESSION['id']);
//        $req = $bdd->prepare("INSERT INTO prestation (debut_datetime,fin_datetime,parent_id,nounou_id) VALUES (:debut_datetime, :fin_datetime, :parent_id, :nounou_id)");
//        $req->execute(array(
//            'debut_datetime' => $debut_datetime,
//            'fin_datetime' => $fin_datetime,
//            'parent_id' => $_SESSION['id'],
//            'nounou_id' => 4,
//        ));
            //$d = clone $date;
            //$d = $d->modify("+ 1 day")->format('Y-m-d');
        }
    }
    //var_dump($d);
    
    //var_dump($date);
    var_dump($d);
endwhile;
