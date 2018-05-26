<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php require './Month.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="calendar.css"/>
    </head>
    <body>
        <?php
        try {
            if (isset($_GET['month']) && isset($_GET['year'])) {
                $month = new Month($_GET['month'], $_GET['year']);
            } else if (isset($_GET['month'])) {
                $month = new Month($_GET['month'], null);
            } else if (isset($_GET['year'])) {
                $month = new Month(null, $_GET['year']);
            } else {
                $month = new Month();
            }
        } catch (Exception $e) {
            $month = new Month();
        }
        $start = $month->getStartingDay()->modify('last monday');
        
        ?>
        <div class="d-flex flex-row align-items-center justify-content-between mx-sm-2">
        <h1><?= $month->toString(); ?></h1>
        <div>
            <a href="planning_test2.php?month=<?= $month->previousMonth()->month;?>&year=<?= $month->previousMonth()->year;?>" class="btn btn-primary">&lt;</a>
            <a href="planning_test2.php?month=<?= $month->nextMonth()->month;?>&year=<?= $month->nextMonth()->year;?>"class="btn btn-primary">&gt;</a>
        </div>
        </div>
        
        <table class="calendar__table calendar__table--<?= $month->getWeeks(); ?>weeks">
            <?php for($i = 0;$i < $month->getWeeks(); $i++){?>
            <tr>
                <?php foreach($month->days as $k => $day){
                    $start2 = clone $start;
                    $date = $start2->modify("+" . ($k + $i * 7) . "days");?>
                <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
                    <?php if ($i===0){?>
                    <div class="calendar__weekday"><?= $day;?></div>
                    <?php } ?>
                    <div class="calendar__day"><?= $date->format('d');?></div>
                </td>
                <?php } ?>
            </tr>
            <?php }?>
        </table>
    </body>
</html>
