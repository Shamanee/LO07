<?php

class Calendrier {

    private $firstDay;
    private $lastDay;
    private $nextYear;
    private $prevYear;
    private $currentYear;
    private $nextMonth;
    private $prevMonth;
    private $datesMonth;
    private $nomJour;
    private $numeroJour;

    public function __construct() {
        $this->firstDay = date('Y-m-d', strtotime('first day of this month'));
        $this->lastDay = date('Y-m-d', strtotime('last day of this month'));
        $this->nextYear = date('Y-m-d', strtotime('+1 year'));
        $this->prevYear = date('Y-m-d', strtotime('-1 year'));
        $this->nextMonth = DateTime::createFromFormat('Y-m-d', $this->firstDay)->add(new DateInterval('P1M'))->format('Y-m-d');
        $this->prevMonth = DateTime::createFromFormat('Y-m-d', $this->firstDay)->sub(new DateInterval('P1M'))->format('Y-m-d');
        $this->currentYear = date('Y');
        $this->datesMonth = array();
        $this->nomJour = $this->datesMonth;
        $this->numeroJour = $this->datesMonth;
    }

    public function afficheMois() {
        echo strftime('%B', strtotime($this->firstDay));
    }

    public function afficheAnnee() {
        echo $this->currentYear;
    }

    public function afficheAnneePrecedent() {
        echo date('Y', strtotime($this->prevYear));
    }

    public function afficheMoisPrecedent() {
        echo strftime('%B', strtotime($this->prevMonth));
    }

    public function afficheAnneeSuivant() {
        echo date('Y', strtotime($this->nextYear));
    }

    public function afficheMoisSuivant() {
        echo strftime('%B', strtotime($this->nextMonth));
    }

    public function afiicheNomJour() {

        $period = new DatePeriod(
                new DateTime($this->firstDay), new dateInterval('P1D'), (new DateTime($this->lastDay))->modify('+ 1 day'));

        foreach ($period as $p) {
            array_push($this->nomJour, $p->format('Y-m-d'));
        }

        foreach ($this->nomJour as $d) {
            echo '<th>' . strftime('%a', strtotime($d)) . '</th>';
        }
        return $this->nomJour;
    }

    public function afiicheNumeroJour() {

        $period = new DatePeriod(
                new DateTime($this->firstDay), new dateInterval('P1D'), (new DateTime($this->lastDay))->modify('+ 1 day'));

        foreach ($period as $p) {
            array_push($this->numeroJour, $p->format('Y-m-d'));
        }

        foreach ($this->numeroJour as $d) {
            echo '<td>' . date('d', strtotime($d)) . '</td>';
        }
        return $this->numeroJour;
    }

}
