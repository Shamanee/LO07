<?php //require '../bdd/connex_bdd.php';   ?>
<button id='btn_utilisateur'>Utilisateurs</button>
<button id='btn_nounou'>Nounous</button>
<div id='table_utilisateur' style='display: none'>
    <h2>Liste Utilisateurs</h2>
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
    <h2>Liste Nounous</h2>
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
        $requete = $bdd->query("SELECT User_Type, prenom,nom,email,ville FROM utilisateur WHERE User_Type='nounou'");
        while ($donnees = $requete->fetch()) {
            if ($donnees['User_Type'] != 'admin') {
                echo "<tr>\n\t<td>" . $donnees['User_Type'] . "</td>\n<td>" . $donnees['prenom'] . "</td>\n<td>" . $donnees['nom'] . "</td>\n<td>" . $donnees['email'] . "</td>\n<td>" . $donnees['ville'] . "</td>\n</tr>";
            }
        }
        $requete->closeCursor();
        ?>
    </table>
</div>
<script>
    $("#btn_utilisateur").on('click', function () {
        $('#table_utilisateur').show();
        $('#table_nounou').hide();
    });
    $("#btn_nounou").on('click', function () {
        $('#table_nounou').show();
        $('#table_utilisateur').hide();
    });
</script>


