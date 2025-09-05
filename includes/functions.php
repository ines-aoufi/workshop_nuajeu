<?php

// Tirer une rareté selon les probabilités
function tirerRarete() {
    $r = mt_rand() / mt_getrandmax();

    if ($r < 0.94) {
        return "common";
    } elseif ($r < 0.99) {
        return "rare";
    } else {
        return "secret";
    }
}

// Récupérer une carte aléatoire d'une rareté donnée
function tirerCarteParRarete($pdo, $rarete) {
    $stmt = $pdo->prepare("SELECT * FROM Carte WHERE rarity = :rarete");
    $stmt->execute(['rarete' => $rarete]);
    $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($cartes) === 0) {
        return null;
    }

    $index = array_rand($cartes);
    return $cartes[$index];
}

// Ouvrir un booster (3 cartes)
function ouvrirBooster($pdo) {
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

function ajoutcollection($pdo, $userId, $cardId) {
    // Vérifier si la carte existe déjà dans la collection de CE joueur
    $stmt = $pdo->prepare("SELECT amount 
                           FROM user_collection 
                           WHERE user_id = :userId AND card_id = :cardId");
    $stmt->execute([
        'userId' => $userId,
        'cardId' => $cardId
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Si la carte existe déjà pour ce joueur, incrémenter
        $stmt = $pdo->prepare("UPDATE user_collection 
                               SET amount = amount + 1 
                               WHERE user_id = :userId AND card_id = :cardId");
        $stmt->execute([
            'userId' => $userId,
            'cardId' => $cardId
        ]);
    } else {
        // Sinon, ajouter une nouvelle entrée
        $stmt = $pdo->prepare("INSERT INTO user_collection (user_id, card_id, amount) 
                               VALUES (:userId, :cardId, 1)");
        $stmt->execute([
            'userId' => $userId,
            'cardId' => $cardId
        ]);
    }
}

$booster = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booster = ouvrirBooster($pdo);
    $userId = $_SESSION['user_id']; // ⚠️ Assure-toi que la session est bien démarrée

foreach ($booster as $carte) {
    ajoutcollection($pdo, $userId, $carte['id']);
}
}

?>
