/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Fonction inutile, mais qui valait le coup d'être documentée
 * @returns {undefined}
 */
function test(){
    alert("C'est inutile");
}

function premiere_co_nounou_dispo(){
    window.location = 'dispo_form.php';
    alert("C'est votre première connexion. Veuillez saisir vos disponibilités.");
}

function premiere_co_nounou_langue(){
    window.location = 'langue_form.php';
    alert("Veuillez maintenant saisir les langues que vous parlez.");
}

