<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

var_dump($week);

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
?>

<h1><?= $week->toString(); ?></h1>
<div class="menu">
    <?php require './menu_test.php'; ?>
</div>
<div>
    <a href="semaine.php?week=<?= $week->previousWeek()->week; ?>&year=<?= $week->previousWeek()->year; ?>" class="btn btn-primary">&lt;</a>
    <a href="semaine.php?week=<?= $week->nextWeek()->week; ?>&year=<?= $week->nextWeek()->year; ?>"class="btn btn-primary">&gt;</a>
    </div>

<table class="calendar__table">
    <?php //for ($i = 0; $i < 7; $i++) { ?>
    <tr>
        <?php
        foreach ($week->days as $k => $day) {
            $start2 = clone $start;
            $date = $start2->modify("+ $k days");
            //var_dump($date);
            if (isset($events[$date->format('Y-m-d')])) {
                $eventsForDay = $events[$date->format('Y-m-d')];
            } else {
                $eventsForDay = [];
            };
            $isToday = date('Y-m-d') === $date->format('Y-m-d');
            ?>

            <td class="<?= $isToday ? 'is-today' : ''; ?>">
                <div class="calendar__weekday"><?= $day ?></div>
                <div class="calendar__day"><?= $date->format('d') ?></div>
                <?php foreach ($eventsForDay as $event) { ?>
                    <div class="calendar__event">
                        <?php
                        $parentId = $event['parent_id'];
                        $nounouId = $_SESSION['id'];
                        $sql = "SELECT U.nom FROM utilisateur U, prestation P WHERE U.id=$parentId AND P.nounou_id=$nounouId";
                        $req = $bdd->query($sql);
                        $res = $req->fetchAll();
                        //var_dump($res);
                        if (!empty($res)):
                            ?>
                            <?= (new DateTime($event['debut_datetime']))->format('H:i'); ?> - <?= (new DateTime($event['fin_datetime']))->format('H:i'); ?> - <a href="event.php?id=<?= $event['id']; ?>"><?= $res['0']['nom'];
                            ?></a>
                        <?php endif; ?>
                    </div>
                <?php } ?>
            </td>
            <?php
        }
        ?>
    </tr>
    <?php // } ?>
</table>