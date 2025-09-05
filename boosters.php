<?php
include 'includes/header.php';
?>
<h1>Boosters</h1>
<link rel="stylesheet" href="./style/css/boosters.css">
<?php include 'includes/db.php';
?>
<?php
include 'includes/functions.php';
?>
<form id="boosterForm" method="POST">
    <div class="container__index">
        <div class="booster-wrapper">
            <input class="booster" type="image" src="./assets/images/booster-pokemon.png" alt="Ouvrir">
            <img src="assets/images/etoile-blanche.png" alt="Étoile blanche" class="etoile">
        </div>
    </div>
    <button type="submit" id="btnouvrir">Ouvrir</button>
</form>

<div id="cards" style="display:none;">
    <?php if (!empty($booster)): ?>
        <ul>
            <?php foreach ($booster as $carte): ?>
                <li><?= htmlspecialchars($carte["name"]) ?> (<?= htmlspecialchars($carte["rarity"]) ?>)</li>
            <?php endforeach; ?>
        </ul>
        <button class="btnfermer">Fermer</button>
    <?php endif; ?>
</div>

<script>
document.getElementById("boosterForm").addEventListener("submit", function(e) {
    e.preventDefault(); // Empêche le rechargement

    fetch("", { // même page
        method: "POST",
        body: new FormData(this)
    })
    .then(response => response.text())
    .then(html => {
        // Extraire uniquement le contenu du booster retourné
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, "text/html");
        const cards = doc.querySelector("#cards");

        if (cards) {
            document.getElementById("cards").innerHTML = cards.innerHTML;
            document.getElementById("cards").style.display = "block";
        }
    })
    .catch(error => console.error("Erreur :", error));
});
</script>
<?php
include 'includes/footer.php';
?>
