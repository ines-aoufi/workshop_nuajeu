<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet">

<?php

session_start();

require 'includes/db.php';

// Si l'utilisateur n'est pas connecté, on le redirige vers login.php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Si connecté, récupérer le nom
$username = $_SESSION['username'];

include 'includes/header.php';
?>

<h1 style="margin-top: 50px; text-align: center;">Bonjour, <?php echo htmlspecialchars($username); ?></h1>

<?php
include 'includes/footer.php';
?>