<script src='./sortElements.js'></script>

<?php
//require '../bdd/connex_bdd.php';
//require './administration/function.php';
?>
<button id='btn_utilisateur'>Utilisateurs</button>
<button id='btn_nounou'>Nounous</button>
<button id='btn_chiffre'>Chiffres</button>
<div id='table_utilisateur' style='display: none'>
    <?php
    $req = $bdd->query("SELECT COUNT(*) FROM utilisateur WHERE User_Type <> 'admin'");
    $res = $req->fetch();
    $nbUtilisateur = $res['COUNT(*)'];
    ?>
    <h2>Liste Utilisateurs (<?= $nbUtilisateur ?> utilisateurs)</h2>
    <table>
        <tr>
            <th>Type</th>
            <th>Prenom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Ville</th>
        </tr>
        <?php
        /**
         * On effectue une requete pour avoir tous les utilisateur du site, et on les affiche dans un tableau (en excluant l'administrateur du site)
         */
        $requete = $bdd->query('SELECT User_Type, prenom,nom,email,ville FROM utilisateur');
        while ($donnees = $requete->fetch()) {
            if ($donnees['User_Type'] != 'admin') {
                echo "<tr>\n\t<td>" . $donnees['User_Type'] . "</td>\n<td>" . $donnees['prenom'] . "</td>\n<td>" . $donnees['nom'] . "</td>\n<td>" . $donnees['email'] . "</td>\n<td>" . $donnees['ville'] . "</td>\n</tr>";
            }
        }
        $requete->closeCursor();
        ?>
    </table>
</div>
<div id="table_nounou" style='display: none'>
    <?php
    $req1 = $bdd->query("SELECT COUNT(*) FROM utilisateur WHERE User_Type = 'nounou'");
    $res1 = $req1->fetch();
    $nbNounou = $res1['COUNT(*)'];
    ?>
    <h2>Liste Nounous (<?= $nbNounou ?> nounous)</h2>
    <table id="tablenounou">
        <tr>
            <th>Prenom</th>
            <th id='nomnounou'>Nom</th>
            <th>Email</th>
            <th>Ville</th>
            <th id='benefmois'>Bénéfice Mensuel (&euro;)</th>
            <th id="benefsem">Bénéfice Hebdomadaire(&euro;)</th>
            <th>Bloquer</th>
            <th>Profil</th>
        </tr>
        <?php
        /**
         * On effectue une requete pour avoir tous les utilisateur du site, et on les affiche dans un tableau (en excluant l'administrateur du site)
         */
        $requete = $bdd->query("SELECT User_Type,id,prenom,nom,email,ville FROM utilisateur WHERE User_Type='nounou' OR User_Type='blocked'");
        while ($donnees = $requete->fetch()) {
            if ($donnees['User_Type'] === 'nounou') {
                $benefmois = calculBenefNounouMois($donnees['id']);
                $benefsem = calculBenefNounouSemaine($donnees['id']);
                echo "<tr>\n\t<td>" . $donnees['prenom'] . "</td>\n<td>" . $donnees['nom'] . "</td>\n<td>" . $donnees['email'] . "</td>\n<td>" . $donnees['ville'] . "</td>\n<td>" . $benefmois . "</td>\n<td>" . $benefsem . "</td>\n<td>"
                . "<form method='POST' action='administration_traitement.php'>"
                . "<input type='submit' class='button' value='Bloquer' name='bloquer' onclick=\"return confirm('Vous allez bloquer cette personne, êtes vous sûr ?');\"/>"
                . "<input type='hidden' name='idblock' value='" . $donnees['id'] . "'/>"
                . "</form></td>\n"
                . "<td><a href='profil-nounou.php?nom=" . $donnees['nom'] . "'>Profil</a></td>\n</tr>";
            } else {
                echo "<tr>\n\t<td>" . $donnees['prenom'] . "</td>\n<td>" . $donnees['nom'] . "</td>\n<td>" . $donnees['email'] . "</td>\n<td>" . $donnees['ville'] . "</td>\n<td>" . $benefmois . "</td>\n<td>" . $benefsem . "</td>\n<td>"
                . "<form method='POST' action='administration_traitement.php'>"
                . "<input type='submit' class='button' value='Débloquer' name='debloquer' onclick=\"return confirm('Vous allez débloquer cette personne, êtes vous sûr ?');\"/>"
                . "<input type='hidden' name='idblock' value='" . $donnees['id'] . "'/>"
                . "</form></td>\n</tr>";
            }
        }
        $requete->closeCursor();
        ?>
    </table>
</div>
<div id='chiffre' style='display: none'>
    <h2>Les chiffres du site</h2>
    <ul>
        <li><?= $nbNounou ?> Nounous au total</li>
        <li><?= $nbUtilisateur ?> Utilisateurs</li>
        <li><?= calculBenefTotal() ?> &euro; de CA mensuel</li>
    </ul>
</div>
<?php

function calculBenefNounouSemaine($nounouId) {
    require './bdd/connex_bdd.php';
    //require '../classe/Week.php';
    $benefSem = 0;
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
        $reqq = $bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=" . $res['id'] . "");
        $ress = $reqq->fetch();
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
            $benef_Ponc = $benef_Ponc + (7 + 4 * $nb_enf) * intval($diffdate);
        }
    }
    $sql2 = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$week_start' AND '$week_end' AND type='reguliere'";
    $req2 = $bdd->query($sql2);
    while ($res2 = $req2->fetch()) {
        $reqq2 = $bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=" . $res2['id'] . "");
        $ress2 = $reqq2->fetch();
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
            $benef_Reg = $benef_Reg + (10 + ($nb_enf - 1) * 5) * intval($diffdate);
        }
    }
    $sql3 = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$week_start' AND '$week_end' AND type='etrangere'";
    $req3 = $bdd->query($sql3);
    while ($res3 = $req3->fetch()) {
        $reqq3 = $bdd->query("SELECT COUNT(*) FROM prestation_has_enfant WHERE prestation_id=" . $res3['id'] . "");
        $ress3 = $reqq3->fetch();
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
    $benefSem = $benef_Ponc + $benef_Reg + $benef_Etr;
    return $benefSem;
}

//
function calculBenefNounouMois($nounouId) {
    require './bdd/connex_bdd.php';
    //require './classe/Month.php';
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
        $benef_Ponc = $benef_Ponc + (7+4*$nb_enf) * intval($diffdate);
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
        //var_dump($enddate);
        //var_dump($diffdate);
        $benef_Reg = $benef_Reg + (10+(($nb_enf-1)*5)) * intval($diffdate);
        //var_dump($benef_Reg);
    }
    $sql3 = "SELECT debut_datetime, fin_datetime, id FROM prestation WHERE nounou_id=$nounouId AND debut_datetime BETWEEN '$month_start' AND '$month_end' AND type='etrangere'";
    $req3 = $bdd->query($sql3);
    while ($res3 = $req3->fetch()) {
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
        $benef_Etr = $benef_Etr + 15 * $nb_enf * intval($diffdate);
    }
    $benef = $benef_Ponc + $benef_Reg + $benef_Etr;
    return $benef;
}

//
function calculBenefTotal() {
    require './bdd/connex_bdd.php';
    $sql = "SELECT id FROM utilisateur WHERE User_Type = 'nounou'";
    $req = $bdd->query($sql);
    $benef = 0;
    while ($res = $req->fetch()) {
        $benef += calculBenefNounouMois($res['id']);
    }
    return $benef;
}

//
?>
<script>
    $("#btn_utilisateur").on('click', function () {
        $('#table_nounou').fadeOut().delay(1500);
        $('#chiffre').fadeOut().delay(1500);
        $('#table_utilisateur').fadeIn();
    });
    $("#btn_nounou").on('click', function () {
        $('#table_utilisateur').fadeOut().delay(1500);
        $('#chiffre').fadeOut().delay(1500);
        $('#table_nounou').fadeIn();
    });
    $("#btn_chiffre").on('click', function () {
        $('#table_utilisateur').fadeOut().delay(1500);
        $('#table_nounou').fadeOut().delay(1500);
        $('#chiffre').fadeIn();
    });
</script>

<script>
    var table = $('#tablenounou');
    $('#nomnounou, #benefmois, #benefsem')
            .wrapInner('<span title="sort this column"/>')
            .each(function () {

                var th = $(this);
                th.css("cursor", "pointer");
                th.append('<i class="ui-icon ui-icon-caret-2-n-s"></i>');
                thIndex = th.index();
                inverse = false;

                th.click(function () {

                    table.find('td').filter(function () {
                        return $(this).index() === thIndex;

                    }).sortElements(function (a, b)
                    {
                        if ($.isNumeric($.text([a])))
                        {
                            x = $.text([a]);
                              
                            y = $.text([b]);
                            return (eval(x) > eval(y)) ? inverse ? -1 : 1 : inverse ? 1 : -1;
                        } else
                        {
                            return $.text([a]) > $.text([b]) ? inverse ? -1 : 1 : inverse ? 1 : -1;
                            
                        }

                    }, function ()
                    {
                        return this.parentNode;
                    });
                    inverse = !inverse;
                });
            });
</script>