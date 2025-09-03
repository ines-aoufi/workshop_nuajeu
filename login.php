<?php
include 'header.php';
?>

<section id="login">
    <form method="post" action="login.php">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <button type="submit">Se connecter</button>
    </form>
</section>


<?php
include 'footer.php';
?>