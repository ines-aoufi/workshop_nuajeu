<?php
include 'includes/header.php';
require 'includes/db.php';

    try {
        // Requête pour récupérer toutes les cartes dans l'ordre de rareté
        $stmt = $pdo->query("SELECT user_collection.card_id, carte.id, carte.rarity, carte.name, user_collection.amount FROM user_collection INNER JOIN carte ON user_collection.card_id=carte.id ORDER BY `carte`.`rarity` ASC;");

        // Vérifier qu'il y  a des résultats
        $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des cartes : " . $e->getMessage());
    }
?>

<section class="container">
    <div class="header-collection">
        <h1>Ma Collection</h1>
        <a class="filter" href="">Rareté</a>
        <a class="filter" href="">Taille</a>
    </div>

    <ul class="list-cards">
        <?php foreach ($cartes as $carte): ?>
            <li class="card">
                <p class="amount">x<?= htmlspecialchars($carte['amount']) ?></p>
                <!-- Récupérer le nom de la carte qu'on a, et récupérer l'image associée. -->
                <img src="./assets/images/<?= htmlspecialchars($carte['name'])?>.png" alt="">
            </li>
        <?php endforeach; ?>
    </ul>

</section>

<?php
include 'includes/footer.php';
?>