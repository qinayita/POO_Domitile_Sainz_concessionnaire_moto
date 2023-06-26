<?php
require_once '../Model/Manager/DbManager.php';
require_once '../Model/Manager/MotoManager.php';
require_once '../Model/Manager/UserManager.php';
require_once '../autoload.php';

$db = new DbManager();
$motoManager = new MotoManager();
$userManager = new UserManager();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $type = $_POST['type'];

    $motoManager->addMoto($marque, $modele, $type);

    $_SESSION['successMessage'] = 'La moto a été ajoutée avec succès.';

    header('Location: ../index.php');
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une moto</title>
    <style>
        .add-form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .add-form label {
            display: block;
            margin-bottom: 10px;
        }

        .add-form input[type="text"],
        .add-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .add-form input[type="submit"] {
            width: 100%;
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
<h1>Ajouter une moto</h1>
<div class="add-form">
    <form method="POST" action="add_moto.php">
        <label for="marque">Marque :</label>
        <input type="text" name="marque" id="marque" required><br>

        <label for="modele">Modèle :</label>
        <input type="text" name="modele" id="modele" required><br>

        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <option value="Enduro">Enduro</option>
            <option value="Custom">Custom</option>
            <option value="Sportive">Sportive</option>
            <option value="Roadster">Roadster</option>
        </select><br>

        <input type="submit" value="Ajouter">
    </form>
</div>
</body>
</html>



