<?php
if (isset($loginError)) { ?>
    <p class="error-message"><?php echo $loginError; ?></p>
<?php } ?>
<form method="POST" action="index.php">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" id="username" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required><br>

    <input type="submit" value="Se connecter" class="login-button">
</form>
