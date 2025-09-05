<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">

    <!-- Liens vers les fichiers CSS déja compilés -->
    <link rel="stylesheet" href="style/css/header.css">
    <link rel="stylesheet" href="style/css/footer.css">
    <link rel="stylesheet" href="style/css/main.css">
    <link rel="stylesheet" href="style/css/collection.css">
    <link rel="stylesheet" href="style/css/boosters.css">
    <link rel="stylesheet" href="style/css/login.css">

    <title>Workshop Nuajeu</title>
</head>

<body>

    <section id="login">
        <form method="post" action="login-action.php">
            <img class="logo" src="./assets/images/logo_blanc.png" alt="">
            <div class="input-wrapper">
                <img class="icons" src="./assets/images/user-icon.png" alt="">
                <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            </div>

            <button type="submit">Se connecter</button>
        </form>
    </section>

    <?php
    include 'includes/footer.php';
    ?>