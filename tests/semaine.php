<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SESSION['User_Type'] !== 'nounou') {
    header('Location:../error403.html');
}
require '../classe/Week.php';
require '../classe/Prestation.php';
require '../bdd/connex_bdd.php';
require './debug.php';
$pdo = get_pdo();

try {
    if (isset($_GET['week']) && isset($_GET['year'])) {
        $week = new Week($_GET['week'], $_GET['year']);
    } else if (isset($_GET['week'])) {
        $week = new Week($_GET['week'], null);
    } else if (isset($_GET['year'])) {
        $week = new Week(null, $_GET['year']);
    } else {
        $week = new Week();
    }
} catch (Exception $e) {
    $week = new Week();
}

$events = new Prestation($pdo);
$start = $week->getStartingDay();
$start = $start->format('N') === '1' ? $start : $week->getStartingDay()->modify('last monday');
//$start : $week->getStartingDay()->modify('last monday');
//$weeks = $week->getWeek();
$end = (clone $start);
$end = $end->modify('+ 6 days');
$events = $events->getPrestationBetweenByDay($start, $end);
require'./views/header.php';
//var_dump($start);
//var_dump($end);
//dd($events);
?>

<h1><?= $week->toString(); ?></h1>
<div class="menu">
    <?php require './menu_test.php'; ?>
</div>
<div>
    <a href="semaine.php?week=<?= $week->previousWeek()->week; ?>&year=<?= $week->previousWeek()->year; ?>" class="btn btn-primary">&lt;</a>
    <a href="semaine.php?week=<?= $week->nextWeek()->week; ?>&year=<?= $week->nextWeek()->year; ?>"class="btn btn-primary">&gt;</a>
    <a href="planning_test2.php" class="btn btn-primary">Mois</a>
</div>

<table class="calendar__table">


    <?php //for ($i = 0; $i < 7; $i++) { ?>
    <tr>
        <td class="calendar__heure"></td>
        <?php
        foreach ($week->days as $k => $day) {
            $start2 = clone $start;
            $date = $start2->modify("+ $k days");
            //var_dump($date);

            $isToday = date('Y-m-d') === $date->format('Y-m-d');
            ?>

            <td class="<?= $isToday ? 'is-today' : ''; ?>">
                <div class="calendar__weekday"><?= $day ?></div>
                <div class="calendar__day"><?= $date->format('d') ?></div>

            </td>
            <?php
        }
        ?>
    </tr>



    <?php for ($heure = 0; $heure < 24; $heure++): ?>
        <tr class="calendar__heure">
            <td><?= $heure ?></td>
            <?php
            foreach ($week->days as $k => $day):
                $start3 = clone $start;
                $date = $start3->modify("+ $k days");
                //var_dump($date->format('Y-m-d'));
                if (isset($events[$date->format('Y-m-d')])) {
                    $eventsForHours = $events[$date->format('Y-m-d')];
                } else {
                    $eventsForHours = [];
                };
                //var_dump($eventsForHours);
                ?>
                <td class="test">

                    <?php foreach ($eventsForHours as $k => $event) : ?>

                        <div>

                            <?php
                            //var_dump($event);
                            if (isset($event[$k])) {
                                $parentId = $event[$k]['parent_id'];
                            } else {
                                $parentId = $event['parent_id'];
                            }
                            $nounouId = $_SESSION['id'];
                            $heure_p = $date->format("Y-m-d {$heure}:i");
                            //var_dump($heure_p);
                            
                            $sql = "SELECT U.nom FROM utilisateur U, prestation P WHERE U.id=$parentId AND P.nounou_id=$nounouId AND P.id=".$event['id']."";
                            $req = $bdd->query($sql);
                            $res = $req->fetch();
                            
                            
                            //if (isset($diff_date)):
                            
                            //var_dump($res);


                                //$fin_p = $res[0]['fin_datetime'];
                                //var_dump($event['debut_datetime']);
                                //var_dump($debut_datetime);
                                $heure_modif = $heure;
                                if ($heure < 10) {

                                    $heure_modif = "0" . $heure_modif;
                                }
                                //var_dump($date->format("Y-m-d {$heure_modif}:i:s"));
                                $date_modif = $date->format("Y-m-d {$heure_modif}:i:s");
                                //date_modify($date_modif,"+ 1 hour");
                                //var_dump($date_modif); 
                                ?>
                                <?php
                                if ($date_modif < $event['fin_datetime'] && $date_modif >= $event['debut_datetime']):
                                    //var_dump(intval($debut_datetime->format("H")));
                                    //var_dump(intval($fin_datetime->format("H")));
                                    ?>
                                    <div style="background-color: beige">
                                        <a href="event.php?id=<?= $event['id']; ?>"><?= $res['nom'] ?></a>
                                    </div>
                                    <?php
                                endif;
                                ?>
                                <?php
                            //endif;
                            ?>

                        </div>

                    <?php endforeach; ?>
                </td>   
            <?php endforeach; ?>
        </tr>
    <?php endfor; ?>
    <?php // }       ?>
</table>