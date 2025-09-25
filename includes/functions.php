<?php

// Tirer une rareté selon les probabilités (94% common, 5% rare, 1% secret par carte dans un booster)
function tirerRarete()
{
    $r = mt_rand() / mt_getrandmax();
    if ($r < 0.9467) { // 94.67% communes
        return "common";
    } elseif ($r < 0.9967) { // 5% rares (0.9467 + 0.05 = 0.9967)
        return "rare";
    } else { // 0.33% secrètes
        return "secret";
    }
}

// Récupérer une carte aléatoire d'une rareté donnée (correction: table 'carte' en minuscule)
function tirerCarteParRarete($pdo, $rarete)
{
    $stmt = $pdo->prepare("SELECT * FROM carte WHERE rarity = :rarete");
    $stmt->execute(['rarete' => $rarete]);
    $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($cartes) === 0) {
        // Fallback : Si pas de cartes de cette rareté, tire une common
        return tirerCarteParRarete($pdo, 'common');
    }

    $index = array_rand($cartes);
    return $cartes[$index];
}

// Ouvrir un booster (3 cartes)
function ouvrirBooster($pdo)
{
    $booster = [];
    for ($i = 0; $i < 3; $i++) {
        $rarete = tirerRarete();
        $carte = tirerCarteParRarete($pdo, $rarete);
        if ($carte) {
            $booster[] = $carte;
        }
    }
    return $booster;
}

// Ajouter une carte à la collection de l'utilisateur
function ajoutcollection($pdo, $userId, $cardId)
{
    if (!$userId || !$cardId) {
        return false; // Erreur si IDs manquants
    }

    // Vérifier si la carte existe déjà
    $stmt = $pdo->prepare("SELECT amount FROM user_collection WHERE user_id = :userId AND card_id = :cardId");
    $stmt->execute([
        'userId' => $userId,
        'cardId' => $cardId
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Incrémenter
        $stmt = $pdo->prepare("UPDATE user_collection SET amount = amount + 1 WHERE user_id = :userId AND card_id = :cardId");
        return $stmt->execute(['userId' => $userId, 'cardId' => $cardId]);
    } else {
        // Ajouter nouvelle
        $stmt = $pdo->prepare("INSERT INTO user_collection (user_id, card_id, amount) VALUES (:userId, :cardId, 1)");
        return $stmt->execute(['userId' => $userId, 'cardId' => $cardId]);
    }
}

function handleBoosterPost($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    }

    // DEBUG : Logs
    error_log("Début handleBoosterPost");
    if (ob_get_level()) ob_clean();

    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        error_log("Erreur: Pas de user_id en session");
        http_response_code(401);
        echo '<p>Erreur: Connectez-vous (session manquante).</p>';
        exit;
    }

    $userId = $_SESSION['user_id'];
    error_log("User  ID: $userId");

    try {
        $booster = ouvrirBooster($pdo);
        error_log("Booster généré: " . count($booster) . " cartes");
    } catch (Exception $e) {
        error_log("Erreur ouvrirBooster: " . $e->getMessage());
        echo '<p>Erreur génération booster: ' . $e->getMessage() . '</p>';
        exit;
    }

    if (empty($booster)) {
        error_log("Booster vide");
        echo '<p>Aucune carte (BDD vide ?).</p>';
        exit;
    }

    // Ajout collection
    foreach ($booster as $carte) {
        error_log("Ajout carte ID: " . $carte['id'] . " pour user $userId");
        if (!ajoutcollection($pdo, $userId, $carte['id'])) {
            error_log("Échec ajout carte: " . $carte['id']);
        }
    }

    // Fragment HTML
    echo '<ul>';
    foreach ($booster as $carte) {
        $imgPath = './assets/images/' . htmlspecialchars($carte['name']) . '.png';
        echo '<li><img src="' . $imgPath . '" alt="' . htmlspecialchars($carte['name']) . '" class="cards-img"></li>';
    }
    echo '</ul><button class="btnfermer">Fermer</button>';
    exit;
}
