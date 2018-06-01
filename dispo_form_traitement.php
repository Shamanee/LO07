<?php

session_start();
require './bdd/connex_bdd.php';

$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$heure_debut = [];
$heure_fin = [];
foreach ($jours as $k => $value) {
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
            $heure_debut = $heure_debut->format('H:i:s');
            $heure_fin = $heure_fin->format('H:i:s');
            var_dump($h_deb);
            var_dump($h_fin);
            var_dump($heure_debut);
            var_dump($heure_fin);

            //$req=$bdd->exec("INSERT INTO disponibilite (Debut,Fin,jour,utilisateur_id) VALUES ('{$heure_debut->format('H:i')}','{$heure_fin->format('H:i')}','".$k."',".$_SESSION['id'].")");
            //$req=$bdd->exec("INSERT INTO disponibilite (Debut,Fin,jour,utilisateur_id) VALUES ('00:00:00,'23:59:59','$k',".$_SESSION['id'].")");
            $req = $bdd->exec("INSERT INTO disponibilite (Debut, Fin, jour, utilisateur_id) VALUES ('$h_deb', '$h_fin', '$k', " . $_SESSION['id'] . ")");
            //$req=$bdd->exec("INSERT INTO disponibilite (Debut, Fin, jour, utilisateur_id) VALUES ($heure_debut, $heure_fin, '$k', ".$_SESSION['id'].")");

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

