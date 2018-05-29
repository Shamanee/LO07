<?php

function dd($vars) {
    echo '<pre>';
    print_r($vars);
    echo '</pre>';
}

function h($str) {
    if ($str === null) {
        return '';
    } else {
        return htmlentities($str);
    }
}

function get_pdo() {
    $user = 'root';
    $password = '';
    $dataSourceName = 'mysql:host=localhost;dbname=projetlo07db';
    return new PDO($dataSourceName, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
}

function e404() {
    require './error404.html';
    exit();
}
