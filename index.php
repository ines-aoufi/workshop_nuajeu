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

<!-- Carte aléatoires du joueur -->
<div class="cards-row hidden-cards">
    <?php foreach ($cartes as $carte): ?>
        <div class="card">
            <img src="./assets/images/<?= htmlspecialchars($carte['name']) ?>.png" alt="<?= htmlspecialchars($carte['name']) ?>">
        </div>
    <?php endforeach; ?>
</div>

<div class="container__index">
    <div class="booster-wrapper">
        <img src="assets/images/booster-pokemon.png" alt="Booster Pokémon" class="booster">
        <img src="assets/images/etoile-blanche.png" alt="Étoile blanche" class="etoile">
    </div>
</div>

<style>
    .cards-row {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
        position: relative;
        height: 0;
    }

    .cards-row .card {
        width: 150px;
        opacity: 0;
        transition: all 0.6s ease;
    }

    .cards-row.show .card {
        opacity: 1;
        transform: translate(0, 0) scale(1);
        position: relative;
        /* les cartes se placent côte à côte */
    }
</style>


<?php
include 'includes/footer.php';
?>