<?php
// --- DEV: afficher les erreurs (désactive en prod) ---
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Toujours démarrer la session AVANT tout output
session_start();

// Inclusion robuste, relative à ce fichier
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';

// Petite normalisation basique (facultatif)
if ($username !== '') {
    // Ex: limiter longueur pour éviter entrées bizarres
    $username = mb_substr($username, 0, 100);
}

if ($username === '') {
    header('Location: login.php?error=empty');
    exit;
}

try {
    // 1) Chercher l'utilisateur
    // `user` est un nom sensible → backticks
    $stmt = $pdo->prepare('SELECT `id`, `name` FROM `user` WHERE `name` = :name LIMIT 1');
    $stmt->execute([':name' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // 2) Créer l'utilisateur s'il n'existe pas
        $insert = $pdo->prepare('INSERT INTO `user` (`name`) VALUES (:name)');
        $insert->execute([':name' => $username]);

        $user_id = (int)$pdo->lastInsertId();
        $user = [
            'id'   => $user_id,
            'name' => $username
        ];

        // 3) (Optionnel) Pré-remplir la collection avec amount=0 pour chaque carte
        // Table en minuscule `carte` selon ton dictionnaire
        $cards = $pdo->query('SELECT `id` FROM `carte`')->fetchAll(PDO::FETCH_ASSOC);

        if ($cards) {
            $insertCollection = $pdo->prepare(
                'INSERT INTO `user_collection` (`card_id`, `amount`, `user_id`) VALUES (:card_id, 0, :user_id)'
            );
            foreach ($cards as $card) {
                $insertCollection->execute([
                    ':card_id' => (int)$card['id'],
                    ':user_id' => (int)$user['id']
                ]);
            }
        }
    }

    // 4) Stocker en session + rediriger
    $_SESSION['user_id']  = (int)$user['id'];
    $_SESSION['username'] = $user['name'];

    header('Location: index.php');
    exit;
} catch (Throwable $e) {
    // En dev : voir l’erreur ; en prod : logger et rediriger
    // echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>'; exit;
    header('Location: login.php?error=server');
    exit;
}
