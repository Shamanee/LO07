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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-light bg-lights" style="background-color: #ffd1dd; margin-bottom: 0px;">
            <a class="navbar-brand" href="accueil.php">
                Super-Nounou
            </a>
        </nav>
        <div class="bg-1">
            <div class="container">
                <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel" >
                        <div class="panel-heading">
                            <div class="panel-title">Inscription</div>
                            <hr/>
                            <div style="padding-top:10px" class="panel-body" >
                                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                                <form id="loginform" class="form-horizontal" role="form" method='POST' action="inscription_traitement.php">
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <label>Vous êtes ?</label><br/>
                                        <label class="radio-inline"><input type="radio" name="type" value="nounou" id="nounou"/>Une nounou</label>
                                        <label class="radio-inline"><input type="radio" name="type" value="parent" id="parent"/>Un parent</label>
                                    </div>
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" name="prenom" class="form-control" placeholder="Prénom" required/><br/>
                                    </div>
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" name="nom" class="form-control" placeholder="Nom" required/><br/>
                                    </div>
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <input type="text" name="ville" class="form-control" placeholder="Ville" required/><br/>
                                    </div>
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type='date' name='naissance' class="form-control" placeholder="Date Naissance" required/><br/>
                                    </div>
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" name="email" class="form-control" placeholder="Mail" required/><br/>
                                    </div>
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" name="password" class="form-control" placeholder="Mot de Passe" required/><br/>
                                    </div>
                                    <div style="margin-top:10px" class="form-group">
                                        <div class="col-sm-12 controls">
                                            <input id="btn-login" class="btn" type="submit" value="Inscription"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 control">
                                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                                Vous avez déjà un compte ? 
                                                <a href="connexion.php">
                                                    Connectez-vous ici
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--<form id="loginform" class="form-horizontal" role="form" method='POST' action="inscription_traitement.php">
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
            </form>-->
    </body>
</html>
