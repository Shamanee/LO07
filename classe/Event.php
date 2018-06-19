<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event : Un objet de la classe Event est une prestation unique
 *
 * @author Timothée
 */
class Event {

    private $id;
    private $debut_datetime;
    private $fin_datetime;
    private $utilisateur_id;
    private $langue_id;
    private $enfant_id;


    /**
     * Permet d'obtenir l'id d'une prestation
     * @return type int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Permet d'obtenir la date et l'heure de début d'une prestation
     * @return type DateTime
     */
    public function getDebut_datetime(){
        return (new DateTime($this->debut_datetime));
    }
    
    /**
     * Permet d'obtenir la date et l'heure de fin d'une prestation
     * @return type DateTime
     */
    public function getFin_datetime() {
        return (new DateTime($this->fin_datetime));
    }
    
    /**
     * Permet d'obtenir l'id du parent ayant demandé la prestation
     * @return type int
     */
    public function getParent_id() {
        return $this->parent_id;
    }
    
    /**
     * Permet d'obtenir l'id de la nounou qui va faire la prestation
     * @return type int
     */
    public function getNounou_id() {
        return $this->nounou_id;
    }
    
    public function getLangue_id(){
    return $this->langue_id;
    }
    
    public function getEnfant_id(){
        return $this->enfant_id;
    }

}
