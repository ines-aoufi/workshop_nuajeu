<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap" rel="stylesheet">

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


    <ul style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <?php foreach ($cartes as $carte): ?>
            <li>
                <?= htmlspecialchars($carte['name']) ?>
                (Rareté : <?= htmlspecialchars($carte['rarity']) ?>,
                Catégorie : <?= htmlspecialchars($carte['category']) ?>,
                Taille : <?= htmlspecialchars($carte['size']) ?>)
            </li>
        <?php endforeach; ?>
    </ul>



<?php
    include 'includes/footer.php';
?>