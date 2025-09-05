<?php
session_start();
include 'includes/header.php';
require 'includes/db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Gestion du tri via l'URL
$validSorts = ['rarity', 'size'];
$sort = $_GET['sort'] ?? 'rarity';
$order = ($_GET['order'] ?? 'desc') === 'desc' ? 'DESC' : 'ASC'; // <-- mettre DESC par défaut

// Mapping pour la colonne SQL
switch ($sort) {
    case 'rarity':
        $orderBy = "carte.rarity $order, carte.name ASC";
        break;
    case 'size':
        $orderBy = "carte.size $order, carte.name ASC"; // assure-toi que la colonne size existe
        break;
    default:
        $orderBy = "carte.rarity DESC, carte.name ASC"; // <-- tri par défaut
}

// Récupération des cartes de l'utilisateur avec amount > 0
try {
    // Récupérer les cartes de l'utilisateur
    $stmt = $pdo->prepare("
        SELECT user_collection.card_id, carte.id, carte.rarity, carte.name, carte.size, user_collection.amount 
        FROM user_collection 
        INNER JOIN carte ON user_collection.card_id = carte.id 
        WHERE user_collection.user_id = :user_id
        AND user_collection.amount > 0
        ORDER BY $orderBy
    ");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer le nombre total de cartes dans la base
    $stmtCount = $pdo->query("SELECT COUNT(*) FROM carte");
    $total_cards = $stmtCount->fetchColumn();

} catch (PDOException $e) {
    die("Erreur lors de la récupération des cartes : " . $e->getMessage());
}
?>

<section class="container-collection">
    <div class="header-collection">
        <h1>Collection</h1>
        <a class="filter" href="?sort=rarity&order=<?= ($sort === 'rarity' && $order === 'ASC') ? 'desc' : 'asc' ?>">Rareté</a>
        <a class="filter" href="?sort=size&order=<?= ($sort === 'size' && $order === 'ASC') ? 'desc' : 'asc' ?>">Taille</a>
    </div>

    <div class="collection-number">
        <?php
        // Compter le nombre de cartes différentes de l'utilisateur (amount > 0)
        $number_unique_cards = count($cartes);
        echo "<h2>$number_unique_cards/$total_cards</h2>";
        ?>
    </div>
    
    <ul class="list-cards">
        <?php if (count($cartes) > 0): ?>
            <?php foreach ($cartes as $carte): ?>
                <li class="card">
                    <p class="amount">x<?= htmlspecialchars($carte['amount']) ?></p>
                    <a data-fancybox="gallery"
                        href="./assets/images/<?= htmlspecialchars($carte['name']) ?>.png"
                        data-caption="<?= htmlspecialchars($carte['name']) ?>">
                        <img src="./assets/images/<?= htmlspecialchars($carte['name']) ?>.png"
                            alt="<?= htmlspecialchars($carte['name']) ?>">
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune carte pour l'instant. Ouvre un booster pour commencer ta collection !</p>
        <?php endif; ?>
    </ul>
</section>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.0/dist/fancybox/fancybox.umd.js"></script>
<script src="js/collection.js"></script>
<?php
include 'includes/footer.php';
?>