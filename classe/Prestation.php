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
    
    private  $pdo;


    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getPrestationBetween ($start,$end){
        require '../bdd/connex_bdd.php';
        $sql = "SELECT * FROM prestation WHERE debut_datetime BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
        $req= $this->pdo->query($sql);
        $res=$req->fetchall();
        return $res;
    }
    
    public function getPrestationBetweenByDay($start,$end){
        $events=$this->getPrestationBetween($start, $end);
        $days = [];
        foreach ($events as $event){
            $date = explode(' ',$event['debut_datetime'])[0];
            if(!isset($days[$date])){
                $days[$date] = [$event];
            }else{
                $days[$date][] = $events;
            }
        }
        return $days;
    }
    
    public function find ($id){
        require '../classe/Event.php';
        $sql2= "SELECT * FROM prestation WHERE id = $id LIMIT 1";
        $statement = $this->pdo->query($sql2);
        $statement->setFetchMode(PDO::FETCH_CLASS, Event::class);
        //$statement=$bdd->query($sql2);
        //$statement->setFetchMode(FETCH_CLASS, Event::class);
        $res=$statement->fetch();
        if ($res === false){
            throw new Exception("Aucun resultat n'a ete trouve");
        }else {
        return $res;
        }
    }
}
