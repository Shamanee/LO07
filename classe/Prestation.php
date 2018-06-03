<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Prestation : Classe des prestation directement depuis la base de données
 *
 * @author Timothée
 */

class Prestation {
    
    private  $pdo;

    /**
     * Construit la prestation comme étant un type d'objet PDO, qui vient directement de la base de données
     * @param type $pdo
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Permet de récupérer de la base de données les prestation entre une date de début et une date de fin
     * (Ici c'est pour chaque jour de 00:00:00 à 23:59:59)
     * @param type $start
     * @param type $end
     * @return type array[Prestation]
     */
    public function getPrestationBetween ($start,$end){
        require '../bdd/connex_bdd.php';
        $sql = "SELECT * FROM prestation WHERE debut_datetime BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
        $req= $this->pdo->query($sql);
        $res=$req->fetchall();
        return $res;
    }
    
    /**
     * Permet de d'avoir les prestations jour par jour et de les ajouter dans un tableau ($days)
     * @param type $start
     * @param type $end
     * @return type array[ string ]
     */
    public function getPrestationBetweenByDay($start,$end){
        $events=$this->getPrestationBetween($start, $end);
        $days = [];
        foreach ($events as $event){
            $date = explode(' ',$event['debut_datetime'])[0];
            if(!isset($days[$date])){
                $days[$date] = [$event];
            }else{
                $days[$date][] = $event;
            }
        }
        return $days;
    }
    
    /**
     * Permet de trouver les prestation dans la base de données 1 par 1 pour les afficher par jour
     * @param type $id int
     * @return type 
     * @throws Exception
     */
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
