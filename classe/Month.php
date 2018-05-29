<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Month
 *
 * @author Timothée
 */
class Month {
    
    public $days = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    
    private $months = ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
    public $month;
    public $year;
    
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
    
    public function getStartingDay(){
        return new DateTime("{$this->year}-{$this->month}-01");
    }


    public function toString() {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }
    
    public function getWeeks(){
        $start = $this->getStartingDay();
        $end = clone $start;
        $end->modify('+1 month -1day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
        if($weeks < 0){
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }
    
    public function  withinMonth($date){
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }
    
    public function nextMonth(){
        $month = $this->month + 1;
        $year = $this->year;
        if($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month,$year);
    }
    
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
