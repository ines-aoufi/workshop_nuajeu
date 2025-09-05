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

try {
    // Récupérer 3 cartes aléatoires de l'utilisateur
    $stmt = $pdo->prepare("
        SELECT user_collection.card_id, carte.name, user_collection.amount
        FROM user_collection
        INNER JOIN carte ON user_collection.card_id = carte.id
        WHERE user_collection.user_id = :user_id
        AND user_collection.amount > 0
        ORDER BY RAND()
        LIMIT 3
    ");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cartes : " . $e->getMessage());
}
?>






<h1 style="margin-top: 50px; text-align: center;">Bonjour, <?php echo htmlspecialchars($username); ?></h1>

    <img src="./assets/images/logo_blanc.png" alt="Booster Pokémon" class="logo logo__main">


<?php
include 'includes/footer.php';
?>