<?php

function calculBenefNounouSemaine($nounouId) {
    require './bdd/connex_bdd.php';
    require './classe/Week.php';
    $benef = 0;
    $benef_Ponc = 0;
    $benef_Etr = 0;
    $benef_Reg = 0;
    $week = new Week();
    $week_start = $week->getStartingDay();
    $week_end = clone $week_start;
    $week_start = $week_start->format("Y-m-d H:i");
    $week_end = $week_end->modify('last day of this week')->format("Y-m-d H:i");
    //var_dump($week_start);
    //var_dump($week_end);
    $sql = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$week_start' AND '$week_end' AND type='ponctuelle'";
    $req = $bdd->query($sql);
    while ($res = $req->fetch()) {
        //var_dump($res);
        $reqq=$bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=".$res['id']."");
           $ress=$reqq->fetch();
           //var_dump($ress);
           $nb_enf = $ress['COUNT(*)'];
        
        if (!empty($res)) {
            $enddate = date_create_from_format("Y-m-d H:i:s", $res['fin_datetime']);
            $startdate = date_create_from_format("Y-m-d H:i:s", $res['debut_datetime']);
            $diffdate = date_diff($enddate, $startdate)->format('%h');
//    var_dump($startdate);
//    var_dump($enddate);
            //var_dump($diffdate);
            //$benef_Ponct= 7 *
            $benef_Ponc = $benef_Ponc + (7+4*$nb_enf) * intval($diffdate);
        }
    }
    $sql2 = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$week_start' AND '$week_end' AND type='reguliere'";
    $req2 = $bdd->query($sql2);
    while ($res2 = $req2->fetch()) {
           $reqq2=$bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=".$res2['id']."");
           $ress2=$reqq2->fetch();
           //var_dump($ress2);
           $nb_enf = $ress2['COUNT(*)'];
        //var_dump($res2);
        if (!empty($res2)) {
            $enddate = date_create_from_format("Y-m-d H:i:s", $res2['fin_datetime']);
            $startdate = date_create_from_format("Y-m-d H:i:s", $res2['debut_datetime']);
            $diffdate = date_diff($enddate, $startdate)->format('%h');
//    var_dump($startdate);
//    var_dump($enddate);
            //var_dump($diffdate);
            //$benef_Ponct= 7 *
            $benef_Reg = $benef_Reg + (10+($nb_enf-1)*5) * intval($diffdate);
        }
    }
    $sql3 = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$week_start' AND '$week_end' AND type='etrangere'";
    $req3 = $bdd->query($sql3);
    while ($res3 = $req3->fetch()) {
        $reqq3=$bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=".$res3['id']."");
           $ress3=$reqq3->fetch();
           //var_dump($ress3);
           $nb_enf = $ress3['COUNT(*)'];
        //var_dump($res3);
        if (!empty($res3)) {
            $enddate = date_create_from_format("Y-m-d H:i:s", $res3['fin_datetime']);
            $startdate = date_create_from_format("Y-m-d H:i:s", $res3['debut_datetime']);
            $diffdate = date_diff($enddate, $startdate)->format('%h');
//    var_dump($startdate);
//    var_dump($enddate);
            //var_dump($diffdate);
            //$benef_Ponct= 7 *
            $benef_Etr = $benef_Etr + 15 * $nb_enf * intval($diffdate);
        }
    }
    $benef = $benef_Ponc + $benef_Reg + $benef_Etr;
    return $benef;
}

function calculBenefNounouMois($nounouId) {
    require './bdd/connex_bdd.php';
    require './classe/Month.php';
    $benef = 0;
    $benef_Ponc = 0;
    $benef_Etr = 0;
    $benef_Reg = 0;
    $month = new Month();
    $month_start = $month->getStartingDay();
    $month_end = clone $month_start;
    $month_start = $month_start->format("Y-m-d H:i");
    $month_end = $month_end->modify('last day of this month')->format("Y-m-d H:i");
    //var_dump($month_start);
    //var_dump($month_end);
    $sql = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$month_start' AND '$month_end' AND type='ponctuelle'";
    $req = $bdd->query($sql);
    while ($res = $req->fetch()) {
        $reqq=$bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=".$res['id']."");
           $ress=$reqq->fetch();
           //var_dump($ress);
           $nb_enf = $ress['COUNT(*)'];
        $enddate = date_create_from_format("Y-m-d H:i:s", $res['fin_datetime']);
        $startdate = date_create_from_format("Y-m-d H:i:s", $res['debut_datetime']);
        $diffdate = date_diff($enddate, $startdate)->format('%h');
        //var_dump($res);
        //var_dump($startdate);
        //var_dump($enddate);
        //var_dump($diffdate);
        $benef_Ponc=$benef_Ponc + (7+4*$nb_enf) * intval($diffdate);
    }
    $sql2 = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$month_start' AND '$month_end' AND type='reguliere'";
    $req2 = $bdd->query($sql2);
    while ($res2 = $req2->fetch()) {
        $reqq2=$bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=".$res2['id']."");
           $ress2=$reqq2->fetch();
           //var_dump($ress);
           $nb_enf = $ress2['COUNT(*)'];
        $enddate = date_create_from_format("Y-m-d H:i:s", $res2['fin_datetime']);
        $startdate = date_create_from_format("Y-m-d H:i:s", $res2['debut_datetime']);
        $diffdate = date_diff($enddate, $startdate)->format('%h');
        //var_dump($res);
        //var_dump($startdate);
        //var_dump($nb_enf);
        //var_dump($diffdate);
        $benef_Reg = $benef_Reg + (10+($nb_enf-1)*5) * intval($diffdate);
    }
    $sql3 = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$month_start' AND '$month_end' AND type='etrangere'";
    $req3 = $bdd->query($sql3);
    while ($res3 = $req3->fetch()) {
        //var_dump($res3['id']);
        $reqq3=$bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=".$res3['id']."");
           $ress3=$reqq3->fetch();
           //var_dump($ress);
           $nb_enf = $ress3['COUNT(*)'];
        $enddate = date_create_from_format("Y-m-d H:i:s", $res3['fin_datetime']);
        $startdate = date_create_from_format("Y-m-d H:i:s", $res3['debut_datetime']);
        $diffdate = date_diff($enddate, $startdate)->format('%h');
        //var_dump($res);
        //var_dump($startdate);
        //var_dump($enddate);
        //var_dump($diffdate);
        //var_dump($nb_enf);
        $benef_Etr = $benef_Etr + 15 * $nb_enf * intval($diffdate);
    }
    $benef = $benef_Ponc + $benef_Reg + $benef_Etr;
    return $benef;
}

//echo calculBenefNounouSemaine(4);
//echo calculBenefNounouMois(4);

function calculBenefTotal() {
    require './bdd/connex_bdd.php';
    $sql = "SELECT id FROM utilisateur WHERE User_Type = 'nounou'";
    $req = $bdd($sql);
    $benef = 0;
    while ($res = $req->fetch()) {
        $benef += calculBenefNounouMois($res['id']);
    }
    return $benef;
}

//echo calculBenefNounouSemaine(4);
//echo calculBenefNounouMois(4);