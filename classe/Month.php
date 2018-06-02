<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Month : Un mois complet pour le calendrier contenant toutes les semaines de ce mois ainsi que tout les jours
 *
 * @author Timothée
 */
class Month {
    
    public $days = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    
    private $months = ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
    public $month;
    public $year;
    
    /**
     * Permet de définir le numéro du mois et l'année que l'on veut donner au calendrier
     * @param type $month
     * @param type $year
     */
    public function __construct($month = null, $year = null) {
        if($month === NULL || $month < 1 || $month > 12){
            $month = intval(date('m'));
        }
        if($year === NULL){
            $year = intval(date('Y'));
        }
        $this->month = $month;
        $this->year = $year;
    }
    
    /**
     * Permet d'obtenir le premier jour d'un mois
     * @return \DateTime
     */
    public function getStartingDay(){
        return new DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * Permet de renvoyer une chaine de caractère avec le mois et l'année du calendrier
     * @return type string
     */
    public function toString() {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }
    
    /**
     * Permet d'obtenir le nombre de semaine dans un mois
     * @return type int
     */
    public function getWeeks(){
        $start = $this->getStartingDay();
        $end = clone $start;
        $end->modify('+1 month -1day');
        $startWeek=intval($start->format('W'));
        $endWeek= intval($end->format('W'));
        if($endWeek===1){
            $endWeek = clone $end;
            $endWeek = intval($endWeek->modify('- 7 days')->format('W')) + 1;
        }
        $weeks = $endWeek - $startWeek + 1;
        if($weeks < 0){
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }
    
    /**
     * Permet de renvoyer une date sous la form Année-Mois
     * @param type $date
     * @return type Date
     */
    public function  withinMonth($date){
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }
    
    /**
     * Permet de passer au mois suivant
     * @return \Month
     */
    public function nextMonth(){
        $month = $this->month + 1;
        $year = $this->year;
        if($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month,$year);
    }
    
    /**
     * Permet de passer au mois précédent
     * @return \Month
     */
    public function previousMonth(){
        $month = $this->month - 1;
        $year = $this->year;
        if($month < 1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month,$year);
    }
}
