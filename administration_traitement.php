<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST)){
            if (isset($_POST['check'])) {
                valider();
            } elseif (isset($_POST['cross'])) {
                refuser();
            }
        }

        function valider() {
            require './bdd/connex_bdd.php';
            $value = verif_bdd();
            echo "La nounou a été validée.";
            $req=$bdd->prepare("UPDATE utilisateur SET User_Type = 'nounou' WHERE User_Type = 'pending' AND id = :id");
            $req->execute(array('id'=>$value));            
        }

        function refuser() {
            require './bdd/connex_bdd.php';
            $value = verif_bdd();
            echo "La nounou a été refusée.";
            $req = $bdd->prepare("DELETE FROM utilisateur WHERE id = :id");
            $req->execute(array('id'=>$value));
        }
        
        function verif_bdd(){
            require './bdd/connex_bdd.php';
            $requete=$bdd->query("SELECT id FROM utilisateur WHERE User_Type = 'pending'");
            $res=$requete->fetch();
            $value = $res['id'];
            return $value;
        }
        
        
        header('refresh:1,url=administration.php');
        ?>