<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f5f5f5;
        }

        .navbar-title {
            margin: 0;
            flex: 1;
            text-align: center;
        }

        .navbar-logout-form {
            margin-left: auto;
        }

        .logout-button {
            width: 150px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="navbar">
    <h1 class="navbar-title">Votre nouveau concessionnaire 2 roues</h1>
    <?php if (isset($isLoggedIn) && $isLoggedIn) { ?>
        <form method="POST" action="index.php" class="navbar-logout-form">
            <input type="hidden" name="logout" value="true">
            <input type="submit" value="Déconnexion" class="logout-button">
        </form>
    <?php } else { ?>
    <?php } ?>
</div>


