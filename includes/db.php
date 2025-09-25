<?php

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=bdd_nuajeu;charset=utf8",
        "root",
        "root"
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
