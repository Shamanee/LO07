<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
?>
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
        </nav><?php
        //var_dump($_SESSION);
        /**
         * Si l'utilisateur est déjà connecté, on lui indique qu'il l'est déjà, puis on le redirige vers la page d'accueil.
         */
        if (isset($_SESSION['User_Type'])) {
            if ($_SESSION['User_Type'] == 'parent' || $_SESSION['User_Type'] == 'nounou' || $_SESSION['User_Type'] == 'admin' || $_SESSION['User_Type'] == 'pending') {
                echo "Vous etes déjà connecté";
                header('Refresh:1; url=accueil.php');
            }
        } else {
            ?><div class='bg-1'>
                <div class="container">
                    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="panel" >
                            <div class="panel-heading">
                                <div class="panel-title">Connexion</div>
                            </div>
                            <div style="padding-top:30px" class="panel-body" >
                                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                                <form id="loginform" class="form-horizontal" role="form" method='POST' action="connexion_traitement.php">
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="email" value="" placeholder="email" required>                                        
                                    </div>
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="mot de passe" required>
                                    </div>
                                    <div style="margin-top:10px" class="form-group">
                                        <div class="col-sm-12 controls">
                                            <input id="btn-login" href="#" class="btn btn-success" type="submit" value="Connexion">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 control">
                                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                                Vous n'êtes pas encore inscrit ? 
                                                <a href="inscription.php">
                                                    Inscrivez-vous ici
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
            <section class="bg-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 texte-1">
                            <div class='w3-xxxlarge text-center icon'>
                                <i class="glyphicon glyphicon-search"></i>
                            </div>
                            <h3>Chercher une nounou</h3>
                            <p>Notre application va chercher des nounous qui sont proches de chez vous.</p>
                        </div>
                        <div class="col-lg-4 texte-1">
                            <div class='w3-xxxlarge text-center icon'>
                                <i class="glyphicon glyphicon-record"></i>
                            </div>
                            <h3>Réserver une nounou</h3>
                            <p>Nous vous mettons en contact avec votre futur nounou.</p>
                        </div>
                        <div class="col-lg-4 texte-1">
                            <div class='w3-xxxlarge text-center icon'>
                                <i class="glyphicon glyphicon-star"></i>
                            </div>
                            <h3>Noter votre nounou</h3>
                            <p>Donnez une note et un avis sur votre nounou afin d'aider les autres utilisateurs à choisir</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="container-fluid">
                <div class="col-md-6 texte-1">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et eros ut leo fringilla tristique at et dui. Pellentesque suscipit interdum placerat. Donec vehicula congue augue, a commodo ex ullamcorper nec. Integer pretium metus vitae augue congue pellentesque. Nunc sit amet nisl interdum orci cursus rutrum. Donec vulputate euismod magna accumsan cursus. Nulla enim ipsum, ultrices ac aliquet vitae, tristique mollis metus. Etiam gravida et massa vitae pulvinar. Pellentesque eget lacus pharetra augue placerat semper.</p>
                </div>
                <div class="col-md-6 bg-1">
                    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                </div>
                <div class="col-md-6 bg-1">
                    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                </div>
                <div class="col-md-6 texte-1">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et eros ut leo fringilla tristique at et dui. Pellentesque suscipit interdum placerat. Donec vehicula congue augue, a commodo ex ullamcorper nec. Integer pretium metus vitae augue congue pellentesque. Nunc sit amet nisl interdum orci cursus rutrum. Donec vulputate euismod magna accumsan cursus. Nulla enim ipsum, ultrices ac aliquet vitae, tristique mollis metus. Etiam gravida et massa vitae pulvinar. Pellentesque eget lacus pharetra augue placerat semper.</p>
                </div>
            </section>
            <?php
        }
        ?>
        <?php require './footer.html'; ?>
    </body>

</html>
<!--<form >
    <label>Email</label>
    <input type="text" name="email"/><br/>
    <label>Mot De Passe</label>
    <input type="password" name="password"/><br/>
    <input type="submit" value="Connexion"/>
</form>-->