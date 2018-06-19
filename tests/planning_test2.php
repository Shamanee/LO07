<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
/**
 * Calendrier qui va servir de planning pour les nounous
 * On regarde si on a passé des données directement dans l'url
 * Si c'est le cas, on va au mois et a l'année correspondant
 * Sinon, ça prend la valeur NULL et on dirige l'utilisateur sur le mois actuel
 */
session_start();
if ($_SESSION['User_Type'] !== 'nounou') {
    header('Location:../error403.html');
}
require '../classe/Month.php';
require '../classe/Prestation.php';
require '../bdd/connex_bdd.php';
require './debug.php';
$pdo = get_pdo();
?>
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

/**
 * On initialise les Prestation dans le calendrier en créant un objet Prestation
 * On calcul ensuite le nécessaire sur le calendrier :
 *      Le premier jour (si celui-ci ne tombe pas un lundi, on revient au dernier lundi du mois précédent)
 *      On calcul le nombre de semaines
 *      Avec ce nombre de semaine, on calcul le date de fin du mois
 * L'objet de type Prestation prend toutes les prestation jour par jour dans le mois complet
 */
$events = new Prestation($pdo);
$start = $month->getStartingDay();
$start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = (clone $start);
$end = $end->modify('+' . (6 + 7 * ($weeks - 1)) . ' days');
$events = $events->getPrestationBetweenByDay($start, $end);
require'./views/header.php';

//dd($events);
?>
<div class="d-flex flex-row align-items-center justify-content-between mx-sm-2">
    <h1><?= $month->toString(); ?></h1>
    <div class="menu">
        <?php require './menu_test.php'; ?>
    </div>
    <div>
        <a href="planning_test2.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
        <a href="planning_test2.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>"class="btn btn-primary">&gt;</a>
        <a href="semaine.php" class="btn btn-primary">Semaine</a>
    </div>
</div>

<table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
    <?php for ($i = 0; $i < $weeks; $i++) { ?>
        <tr>
            <?php
            /**
             * On va affecter un numéro a chaque case du tableau correspondant aux jours du mois
             * On va récupérer toutes les Prestation au bon format de date (ou initialiser 
             *      un tableau vide s'il n'y a pas de prestation prévue pour ce jour)
             * Si la prestation fait bien partie du mois (n'est pas sur les quelques jours du mois précédent/suivant)
             * On affiche les prestation avec les heures de début et de fin ainsi que le nom de l'utilisateur qui a 
             *      saisie la Prestation
             */
            foreach ($month->days as $k => $day) {
                $start2 = clone $start;
                $date = $start2->modify("+" . ($k + $i * 7) . "days");
                if (isset($events[$date->format('Y-m-d')])) {
                    $eventsForDay = $events[$date->format('Y-m-d')];
                } else {
                    $eventsForDay = [];
                };
                $isToday = date('Y-m-d') === $date->format('Y-m-d');
                ?>
                <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?> <?= $isToday ? 'is-today' : ''; ?>">
                    <?php if ($i === 0) { ?>
                        <div class="calendar__weekday"><?= $day; ?></div>
                    <?php } ?>
                    <div class="calendar__day"><?= $date->format('d'); ?></div>
                    <?php foreach ($eventsForDay as $event) { ?>
                        <div>
                            <?php
                            $parentId = $event['parent_id'];
                            if ($_SESSION['id'] === $event['nounou_id']) {
                                $nounouId = $_SESSION['id'];

                                $sql = "SELECT U.nom, P.nounou_id FROM utilisateur U, prestation P WHERE U.id=$parentId AND U.id=P.parent_id AND P.nounou_id=$nounouId";
                                $req = $bdd->query($sql);
                                $res = $req->fetchAll();

                                //var_dump($res);
                                if (!empty($res)):
                                    ?>
                                    <?= (new DateTime($event['debut_datetime']))->format('H:i'); ?> - <?= (new DateTime($event['fin_datetime']))->format('H:i'); ?> - <a href="event.php?id=<?= $event['id']; ?>"><?= $res['0']['nom'];
                                    ?></a>
                                <?php endif; ?>
                            </div>
                        <?php }
                    } ?>
                </td>
        <?php } ?>
        </tr>
<?php } ?>
</table>

<?php
require './views/footer.php';
