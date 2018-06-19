<?php

function calculPrix_ponctuelle($heure_debut, $heure_fin, $nbEnfant) {
    $prix = 0;
    $hd = intval($heure_debut);
    $hf = intval($heure_fin);
    $heure = $hf - $hd;
    $prix = (7+$nbEnfant*4) * $heure;
    echo $prix;
    return $prix;
}

//echo "<form method='POST' action='function_prix'><input type='time' name='heure_debut'/><input type='time' name='heure_fin'/><input type='submit' name='submit'/></form>";
//if (isset($_POST['submit'])) {
//    $heure_debut = $_POST['heure_debut'];
//    $heure_fin = $_POST['heure_fin'];
//    calculPrix_ponctuelle($heure_debut, $heure_fin, 2);
//}