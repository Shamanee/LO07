<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Week
 * Une semaine de travail pour une nounou
 * @author Timothée
 */
class Week {

    //put your code here
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    public function __construct($week = null, $year = null) {
        if ($year === NULL) {
            $year = intval(date('Y'));
        }
        if ($week === NULL || $week < 1 || $week > 53) {
            $week = intval(date('W'));
        }
        $this->week = intval($week);
        $this->year = intval($year);
        $this->month = intval(date('m'));
    }

    /**
     * Permet d'obtenir le premier jour d'un mois
     * @return \DateTime
     */
    public function getStartingDay() {
        
        $date = new DateTime("{$this->year}-01-01");
//        if ($date->format('N')==='4'){
//            $jour = ($this->week) * 7;
//        }else{
//            $jour = ($this->week-1) * 7;
//        }
          $jour=($this->week-1)*7;
//var_dump($jour);
        
        $date->modify('+ '.$jour.' days');
        return $date;
    }

    /**
     * Permet de renvoyer une chaine de caractère avec le numero de semaine et l'année du calendrier
     * @return type string
     */
    public function toString() {
        return 'Semaine ' . $this->week . ' (' . $this->year . ')';
    }

    /**
     * Permet d'obtenir le nombre de semaine dans un mois
     * @return type int
     */
//    public function getWeek() {
//        $start = $this->getStartingDay();
//        $end = clone $start;
//        $end->modify('+1 week -1day');
//        $startDay = intval($start->format('d'));
//        $endDay = intval($end->format('d'));
////        if ($endDay === 1) {
////            $endDay = clone $end;
////            $endDay = intval($endDay->modify('- 7 days')->format('W')) + 1;
////        }
//        $weeks = $endDay - $startDay + 1;
//        if ($weeks < 0) {
//            $weeks = intval($end->format('d'));
//        }
//        return $weeks;
//    }

    /**
     * Permet de passer au mois suivant
     * @return \Month
     */
    public function nextWeek() {
        $week = $this->week + 1;
        $year = $this->year;
        if ($week > 52) {
            $week = 1;
            $year += 1;
        }
        return new Week($week, $year);
    }

    /**
     * Permet de passer au mois précédent
     * @return \Month
     */
    public function previousWeek() {
        $week = $this->week - 1;
        $year = $this->year;
        if ($week < 1) {
            $week = 52;
            $year -= 1;
        }
        return new Week($week, $year);
    }

}
