<?php

try {
    
    $type_bdd = "mysql";
    $host = "localhost";
    $dbname = "php_compte";
    $username = "root";
    $password = "";
    $option =[
        PDO ::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // ici je définie que le mode de récupération des donnés par défaut sera sous forma associative
    ];

    $bdd = new PDO("$type_bdd:host=$host;dbname=$dbname", $username, $password, $option);

} catch (Exception $e) {
    die("ERREUR CONNEXION BDD :" .$e->getMessage());
    
}

// appel des mes fonctions
require_once "functions.php";

// Déclaration des variables "globales"
$errorMessage ="";
$successMessage ="";