<?php
function calculBenefNounouSemaine($nounouId) {
    require './bdd/connex_bdd.php';
    require './classe/Week.php';
    $benef = 0;
    $week = new Week();
    $week_start = $week->getStartingDay();
    $week_end = clone $week_start;
    $week_start = $week_start->format("Y-m-d H:i");
    $week_end = $week_end->modify('last day of this week')->format("Y-m-d H:i");
    //var_dump($week_start);
    //var_dump($week_end);
    $sql = "SELECT debut_datetime, fin_datetime FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$week_start' AND '$week_end'";
    $req = $bdd->query($sql);
    $res = $req->fetch();
    //var_dump($res);
    if(!empty($res)){
    $enddate = date_create_from_format("Y-m-d H:i:s",$res['fin_datetime']);
    $startdate = date_create_from_format("Y-m-d H:i:s",$res['debut_datetime']);
    $diffdate = date_diff($enddate, $startdate)->format('%h');
//    var_dump($startdate);
//    var_dump($enddate);
    //var_dump($diffdate);
    $benef = 7 * intval($diffdate);
    }
    return $benef;
}
function calculBenefNounouMois($nounouId){
    require './bdd/connex_bdd.php';
    require './classe/Month.php';
    $benef = 0;
    $month = new Month();
    $month_start = $month->getStartingDay();
    $month_end = clone $month_start;
    $month_start = $month_start->format("Y-m-d H:i");
    $month_end = $month_end->modify('last day of this month')->format("Y-m-d H:i");
    //var_dump($month_start);
    //var_dump($month_end);
    $sql="SELECT debut_datetime, fin_datetime FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$month_start' AND '$month_end'";
    $req = $bdd->query($sql);
    while($res = $req->fetch()){
        $enddate = date_create_from_format("Y-m-d H:i:s",$res['fin_datetime']);
        $startdate = date_create_from_format("Y-m-d H:i:s",$res['debut_datetime']);
        $diffdate = date_diff($enddate, $startdate)->format('%h');
        //var_dump($res);
        //var_dump($startdate);
        //var_dump($enddate);
        //var_dump($diffdate);
        $benef += 7 * intval($diffdate);
    }
    return $benef;
}
//echo calculBenefNounouSemaine(4);
//echo calculBenefNounouMois(4);

function calculBenefTotal(){
    require './bdd/connex_bdd.php';
    $sql = "SELECT id FROM utilisateur WHERE User_Type = 'nounou'";
    $req = $bdd($sql);
    $benef = 0;
    while($res = $req->fetch()){
        $benef += calculBenefNounouMois($res['id']);
    }
    return $benef;
}

//echo calculBenefNounouSemaine(4);
//echo calculBenefNounouMois(4);