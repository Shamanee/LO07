<?php
/**
 * Permet de débuguer une variable
 * @param type $vars var
 */
function dd($vars) {
    echo '<pre>';
    print_r($vars);
    echo '</pre>';
}

/**
 * Permet de faire la fonction htmlentities() plus rapidement
 * @param type $str
 * @return string
 */
function h($str) {
    if ($str === null) {
        return '';
    } else {
        return htmlentities($str);
    }
}

/**
 * Obtient des données depuis la base de données
 * @return \PDO
 */
function get_pdo() {
    $user = 'root';
    $password = '';
    $dataSourceName = 'mysql:host=localhost;dbname=projetlo07db';
    return new PDO($dataSourceName, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
}

/**
 * Renvoie une erreur 404 si la page n'a pas été trouvée et arrete l'execution du script
 */
function e404() {
    require './error404.html';
    exit();
}
