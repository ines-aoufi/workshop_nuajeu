<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); // Session toujours en premier

include 'includes/db.php'; 
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handleBoosterPost($pdo);
}
include 'includes/header.php';
?>

<link rel="stylesheet" href="./style/css/boosters.css">

<!-- Contenu pour GET : Interface booster -->
<form id="boosterForm" method="POST">
    <div class="container__index">
        <div class="booster-wrapper">
            <input class="booster" type="image" src="./assets/images/booster.png" alt="Ouvrir un booster">
            <img src="./assets/images/etoile-blanche.png" alt="Étoile blanche" class="etoile">
        </div>
        <button type="submit" id="btnouvrir">Ouvrir un Booster</button>
    </div>
</form>

<!-- Div pour les cartes (cachée initialement) -->
<div id="cards" style="display:none; width: 50%; margin: 0 auto; background-color: white; padding: 20px; border-radius: 10px; text-align: center;">
    <!-- Contenu dynamique via JS -->
</div>

<?php include 'includes/footer.php'; ?>
