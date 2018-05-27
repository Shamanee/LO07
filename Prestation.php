<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Prestation
 *
 * @author Timothée
 */

class Prestation {
    public function getPrestationBetween ($start,$end){
        require './connex_bdd.php';
        //$sql = "SELECT * FROM prestation WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}";
        //$req=$bdd->query("SELECT * FROM prestation WHERE fin_datetime BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}");
        $req=$bdd->query("SELECT * FROM prestation WHERE fin_datetime = '13:00:00'");
        $res=$req->fetchall();
        return $res;
    }
}
