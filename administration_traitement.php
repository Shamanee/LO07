<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Quand l'admin utilise un des boutons pour valider la nounou (ou non)
 * On va regarder son choix
 */
if (isset($_POST)){
            if (isset($_POST['check'])) {
                valider($_POST['idaccept']);
            } elseif (isset($_POST['cross'])) {
                refuser($_POST['idaccept']);
            } elseif (isset($_POST['bloquer'])){
                bloquer($_POST['idblock']);
            } elseif (isset($_POST['debloquer'])){
                debloquer($_POST['idblock']);
            }
        }
        /**
         * Valider va modifier le User_Type de la nounou de pending a nounou
         */
        function valider($id) {
            
            require './bdd/connex_bdd.php';
            //$value = verif_bdd_pending();
            echo "La nounou a été validée.";
//            $req=$bdd->prepare("UPDATE utilisateur SET User_Type = 'nounou' WHERE User_Type = 'pending' AND id = :id");
//            $req->execute(array('id'=>$value));
            $req=$bdd->exec("UPDATE utilisateur SET User_Type = 'nounou' WHERE User_Type = 'pending' AND id = $id");
        }
        /**
         * Refuser va supprimer la demander ainsi que l'utilisateur de la base de données
         */
        function refuser($id) {
            require './bdd/connex_bdd.php';
            //$value = verif_bdd_pending();
            echo "La nounou a été refusée.";
            $req = $bdd->exec("DELETE FROM utilisateur WHERE id = $id");
            //$req->execute(array('id'=>$value));
        }
        /**
         * Appelle à la base de données pour avoir l'id des nounous candidates
         * @return type int;
         */
//        function verif_bdd_pending(){
//            require './bdd/connex_bdd.php';
//            $requete=$bdd->query("SELECT id FROM utilisateur WHERE User_Type = 'pending'");
//            $res=$requete->fetch();
//            $value = $res['id'];
//            return $value;
//        }
        
        function bloquer($id){
            require './bdd/connex_bdd.php';
            $requete = $bdd->exec("UPDATE utilisateur SET User_Type = 'blocked' WHERE User_Type = 'nounou' AND id = $id");
        }
        
        function debloquer($id){
            require './bdd/connex_bdd.php';
            $requete = $bdd->exec("UPDATE utilisateur SET User_Type = 'nounou' WHERE User_Type = 'blocked' AND id = $id");
        }
        
//        function verif_bdd_block(){
//            require './bdd/connex_bdd.php';
//            $requete = $bdd->query("SELECT id FROM utilisateur WHERE User_Type = 'nounou'");
//            $res=$requete->fetch();
//            $value = $res['id'];
//            return $value;
//        }
        
        
        header('refresh:1,url=administration.php');
        ?>