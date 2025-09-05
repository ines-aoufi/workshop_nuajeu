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

$booster = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booster = ouvrirBooster($pdo);
}

function ajoutcollection($pdo, $cardId) {
    // Vérifier si la carte existe déjà dans la collection
    $stmt = $pdo->prepare("SELECT amount FROM user_collection WHERE card_id = :cardId");
    $stmt->execute(['cardId' => $cardId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Si la carte existe, incrémenter la quantité
        $stmt = $pdo->prepare("UPDATE user_collection SET amount = amount + 1 WHERE card_id = :cardId");
        $stmt->execute(['cardId' => $cardId]);
    } else {
        // Sinon, insérer une nouvelle entrée avec une quantité de 1
        $stmt = $pdo->prepare("INSERT INTO user_collection (card_id, amount) VALUES (:cardId, 1)");
        $stmt->execute(['cardId' => $cardId]);
    }
}
?>
