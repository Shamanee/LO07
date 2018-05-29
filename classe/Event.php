<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event
 *
 * @author Timothée
 */
class Event {

    private $id;
    private $debut_datetime;
    private $fin_datetime;
    private $utilisateur_id;

    public function getId() {
        return $this->id;
    }
    public function getDebut_datetime(){
        return (new DateTime($this->debut_datetime));
    }
    public function getFin_datetime() {
        return (new DateTime($this->fin_datetime));
    }
    public function getUtilisateur_id() {
        return $this->utilisateur_id;
    }

}
