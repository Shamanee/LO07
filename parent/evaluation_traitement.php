<?php
session_start();
if ($_SESSION['User_Type'] !== 'parent') {
    header('Location:../error403.html');
}
require '../bdd/connex_bdd.php';
$k=0;
while($k<500){
    if(isset($_POST["submit_$k"])){
        var_dump($_POST);
        $req=$bdd->prepare("INSERT INTO evaluation (Note,Commentaire,nounou_id,parent_id,prestation_id) VALUES (:Note,:Commentaire,:nounou_id,:parent_id,:prestation_id)");
        $req->execute(array(
            "Note" => $_POST["note_$k"],
            "Commentaire" => $_POST["commentaire_$k"],
            "nounou_id" => $_POST["nounou_id_$k"],
            "parent_id" => $_SESSION['id'],
            "prestation_id" => $_POST["prestation_id_$k"],
        ));
    }
    $k++;
}