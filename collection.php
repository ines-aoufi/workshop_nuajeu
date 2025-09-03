<?php
include 'includes/header.php';
require 'includes/db.php';

    try {
        // Requête pour récupérer toutes les cartes
        $stmt = $pdo->query("SELECT * FROM carte");

        // Vérifier qu'il y  a des résultats
        $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des cartes : " . $e->getMessage());
    }
?>

<h1>Boosters</h1>

<ul style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <?php foreach ($cartes as $carte): ?>
        <li>
            <?= htmlspecialchars($carte['name']) ?>
            (Rareté : <?= htmlspecialchars($carte['rarity']) ?>,
            Catégorie : <?= htmlspecialchars($carte['category']) ?>,
            Taille : <?= htmlspecialchars($carte['size']) ?>)
            <img src="./assets/images/<?= htmlspecialchars($carte['name'])?>.png" alt="">
        </li>
    <?php endforeach; ?>
</ul>

<?php
include 'includes/footer.php';
?>