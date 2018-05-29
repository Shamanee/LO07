<?php
session_start();
require './bdd/connex_bdd.php';
$target_dir = "photo/";
$uploadOk = 1;
//var_dump($_FILES);

//$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (isset($_POST['submit_photo'])) {
    if (isset($_FILES['photo'])) {
        $taille = count($_FILES['photo']['name']);
        for ($i = 0; $i < $taille; $i++) {
            $target_file = $target_dir . basename($_FILES["photo"]["name"][$i]);
            $maxsize = 12000000;
            $extensions_valides = array('jpg', 'jpeg');
            $extension_upload = strtolower(substr(strrchr($_FILES['photo']['name'][$i], '.'), 1));
            if ($_FILES['photo']['error'][$i] > 0 || !(in_array($extension_upload, $extensions_valides)) || ($_FILES['photo']['size'][$i] > $maxsize)) {
                echo "Erreur lors du transfert <br />";
            } else {
                $nom = $_FILES['photo']['name'][$i];
                $deplacement = move_uploaded_file($_FILES['photo']['tmp_name'][$i], $target_dir . $nom);
                if ($deplacement) {
                    //echo "<br/>Upload reussie. " . $nom . " a été déplacé dans le dossier " . $target_dir . "<br/>";
                    $req=$bdd->prepare('UPDATE utilisateur SET photo= :photo WHERE id = :id');
                    $req->execute(array(
                        'photo' => $target_dir . $_FILES['photo']['name'][$i],
                        'id' => $_SESSION['id'],
                    ));
                    echo "Votre photo a bien été ajoutée.<br/>\n";
                    echo "<img src='photo/" . $_FILES["photo"]["name"][$i] . "' height='300px'><br/>";
                    header('Refresh:2; url=modification_profil.php');
                } else {
                    echo "<br/>Erreur lors de l'upload " . $_FILES["photo"]["Error"][$i] . "<br/>";
                }
            }
        }
    }
}

if(isset($_POST['submit_pass'])){
    $verif=$bdd->prepare('SELECT password FROM utilisateur WHERE id=:id');
    $verif->execute(array('id'=>$_SESSION['id']));
    $resultat=$verif->fetch();
    $isAncien_passCorrect= password_verify($_POST['ancien_password'], $resultat['password']);
    if(isset($_POST['new_password'])&&($isAncien_passCorrect==TRUE)){
        $pass=password_hash($_POST['new_password'],PASSWORD_DEFAULT);
        $req_pass=$bdd->prepare('UPDATE utilisateur SET password= :password WHERE id= :id');
        $req_pass->execute(array(
            'password' => $pass,
            'id' => $_SESSION['id'],
        ));
        echo 'Le mot de passe a été changé.';
        header('Refresh:2; url=modification_profil.php');
    }else if(!isset($_POST['new_password'])){
        echo 'Veuillez saisir un nouveau mot de passe';
        header('Refresh:2; url=modification_profil.php');
    }else{
        echo "L'ancien mot de passe saisi n'est pas bon.";
        header('Refresh:2; url=modification_profil.php');
    }
}

if(isset($_POST['submit_info'])){
        $r=$bdd->prepare('UPDATE utilisateur SET information=:information WHERE id=:id');
        $r->execute(array(
            'information' => $_POST['information'],
            'id' => $_SESSION['id'],
        ));
        if($_SESSION['User_Type']=='nounou'){
            $r2=$bdd->prepare('UPDATE utilisateur SET experience=:experience WHERE id=:id');
            $r2->execute(array(
                'experience' => $_POST['experience'],
                'id' => $_SESSION['id'],
            ));
        }
        /*$requete=$bdd->prepare('SELECT information,experience FROM utilisateur WHERE id=:id');
        $requete->execute(array('id'=>$_SESSION['id']));
        $inf=$requete['information'];
        $expe=$requete['experience'];
        if($inf==''){
            $requete2=$bdd->prepare('UPDATE utilisateur SET information=:information WHERE id=:id');
            $requete2->execute(array(
                'id'=>$_SESSION['id'],
                'information'=>NULL,
            ));
        }
        if($expe==''){
            $requete3=$bdd->prepare('UPDATE utilisateur SET experience=:experience WHERE id=:id');
            $requete3->execute(array(
                'id'=>$_SESSION['id'],
                'experience'=>NULL,
            ));
        }*/
}
?>

