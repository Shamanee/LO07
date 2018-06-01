<?php

session_start();
require './bdd/connex_bdd.php';

$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$heure_debut = [];
$heure_fin = [];
foreach ($jours as $k => $value) {
    $r = $bdd->query("SELECT Debut,Fin FROM disponibilite WHERE utilisateur_id='" . $_SESSION['id'] . "' AND jour=$k");
    $result = $r->fetch();
    if (isset($_POST[$value])) {
        $jour = $_POST[$value];
        //var_dump($jour);
        if (isset($jour)) {
            //var_dump($jour);
            $h_deb = $_POST["heure_debut_" . $jour . ""];
            $h_fin = $_POST["heure_fin_" . $jour . ""];
            //var_dump($h_deb);
            //var_dump($h_fin);
            $array_heure_debut[] = $h_deb;
            $array_heure_fin[] = $h_fin;
            $heure_debut = date_create_from_format('H:i', $h_deb);
            $heure_fin = date_create_from_format('H:i', $h_fin);
            if ($heure_debut != FALSE && $heure_fin != FALSE) {
                $heure_debut = $heure_debut->format('H:i:s');
                $heure_fin = $heure_fin->format('H:i:s');
            }
            var_dump($h_deb);
            var_dump($h_fin);
            var_dump($heure_debut);
            var_dump($heure_fin);
            if ($result[0] === NULL && $result[1] === NULL) {
                $req = $bdd->exec("INSERT INTO disponibilite (Debut, Fin, jour, utilisateur_id) VALUES ('$h_deb', '$h_fin', '$k', " . $_SESSION['id'] . ")");
            } else {
                echo 'TEST TEST TEST';
                $req = $bdd->exec("UPDATE disponibilite SET Debut = '" . $h_deb . "',Fin='" . $h_fin . "' WHERE utilisateur_id = " . $_SESSION['id'] . " AND jour = $k");
            }
            echo 'Vos horraires ont été enregistrés, vous allez être redirigé';
            header('Refresh:2; url=accueil.php');
        }
    }
}



//$req = $bdd->('INSERT INTO disponibilite (jour,debut,fin,utilisateur_id) VALUES (')        
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    