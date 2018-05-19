<?php
session_start();
require './connex_bdd.php';
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
?>

