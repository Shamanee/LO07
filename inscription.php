<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Projet LO07</title>
    </head>
    <body>
        <form method='POST' action="inscription_traitement.php">
            <label>Vous êtes ?</label>
            <input type="radio" name="type" value="nounou" id="nounou"/><label for="nounou">Une nounou</label>
            <input type="radio" name="type" value="parent" id="parent"/><label for="parent">Un parent</label><br/>
            <label>Prénom</label>
            <input type="text" name="prenom" required/><br/>
            <label>Nom</label>
            <input type="text" name="nom" required/><br/>
            <label>Vous habitez à</label>
            <input type="text" name="ville" required/><br/>
            <label>Date de naissance</label>
            <input type='date' name='naissance' required/><br/>
            <label>Email</label>
            <input type="text" name="email" required/><br/>
            <label>Mot De Passe</label>
            <input type="password" name="password" required/><br/>
            <input type="submit" value="Inscription"/>
        </form>
        <p>Déjà un compte ? <a href="connexion.php">Connectez-vous !</a></p>
    </body>
</html>
