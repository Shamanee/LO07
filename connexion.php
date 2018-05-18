<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta author="Timothée Drouot, Thomas Conroux">
        <title>Projet LO07</title>
    </head>
    <body>
        <form method='POST' action="connexion_traitement.php">
            <label>Email</label>
            <input type="text" name="email"/><br/>
            <label>Mot De Passe</label>
            <input type="password" name="password"/><br/>
            <input type="submit" value="Connexion"/>
        </form>
        <p>Pas de compte ? <a href="inscription.php">Inscrivez-vous !</a></p>
    </body>
</html>
