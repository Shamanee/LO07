<?php

session_start();
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
require '../bdd/connex_bdd.php';
require './function_prix.php';
var_dump($_POST);
$jours = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
$d = new DateTime('now');
$datemax = date_create($_POST['datemax']);
var_dump($datemax);
$datetime = new DateTime('now');
$enf = array_unique($_POST['enfant']);
do {
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
            $requete = $bdd->query("SELECT id FROM utilisateur WHERE User_Type='nounou' AND nom='" . $_POST["nounou_$k"] . "'");
            $result = $requete->fetch();
            var_dump($result);
            $req = $bdd->prepare("INSERT INTO prestation (debut_datetime,fin_datetime,parent_id,nounou_id) VALUES (:debut_datetime, :fin_datetime, :parent_id, :nounou_id)");
            $req->execute(array(
                'debut_datetime' => $debut_datetime,
                'fin_datetime' => $fin_datetime,
                'parent_id' => $_SESSION['id'],
                'nounou_id' => $result['id'],
            ));
            echo "Les enfants sont :";
            echo "<ul>";

            foreach ($enf as $enfant) {
                //var_dump($_POST['enfant'][$k]);
                echo "<li>$enfant</li>";
                $reeq = $bdd->query("SELECT E.id AS id_enfant, P.id from enfant E, prestation P WHERE E.Prenom='" . $enfant . "' AND E.utilisateur_id=" . $_SESSION['id'] . " AND P.parent_id = " . $_SESSION['id'] . " AND P.debut_datetime='$debut_datetime' AND P.fin_datetime='$fin_datetime'");
                while ($rees = $reeq->fetch()) {
                    var_dump($rees);
                    $request = $bdd->prepare("INSERT INTO prestation_has_enfant (prestation_id, enfant_id,enfant_utilisateur_id) VALUES (:prestation_id, :enfant_id, :enfant_utilisateur_id)");
                    $request->execute(array(
                        'prestation_id' => $rees['id'],
                        'enfant_id' => $rees['id_enfant'],
                        'enfant_utilisateur_id' => $_SESSION['id'],
                    ));
                }
            }
            echo"</ul>";
            echo "<br/>";
            echo $enfant + 1 . " enfants<br/>";

            echo "prix à payer : ";
            
            $prix = calculPrix_reguliere_par_jour($_POST["heure_debut_$k"], $_POST["heure_fin_$k"], $enfant + 1);
            echo "$prix &euro;";
        }
    }


    //var_dump($d);
    //var_dump($date);
} while ($d < $datemax->modify("last sunday"));



