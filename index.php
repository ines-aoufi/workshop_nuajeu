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

    <img src="./assets/images/logo_blanc.png" alt="Logo Nuajeu" class="logo logo__main">

<?php
include 'includes/footer.php';
?>