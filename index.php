<?php
require_once 'Model/Manager/DbManager.php';
require_once 'Model/Manager/MotoManager.php';
require_once 'Model/Manager/UserManager.php';
require_once 'autoload.php';

$db = new DbManager();
$motoManager = new MotoManager();
$userManager = new UserManager();

session_start();

$isLoggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($userManager->verifyCredentials($username, $password)) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $username;

        header('Location: index.php');
        exit;
    } else {
        $loginError = 'Identifiants invalides. Veuillez réessayer.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    if (isset($_SESSION['confirmDelete']) && $_SESSION['confirmDelete'] === true && isset($_SESSION['deleteId']) && $_SESSION['deleteId'] === $deleteId) {
        // Supprimer la moto
        $motoManager->deleteMoto($deleteId);

        $_SESSION['confirmDelete'] = false;
        $_SESSION['deleteId'] = null;

        $_SESSION['successMessage'] = 'Moto supprimée avec succès.';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['confirmDelete'] = true;
        $_SESSION['deleteId'] = $deleteId;

        header('Location: index.php');
        exit;
    }
}

include 'View/parts/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Détruire la session
    session_destroy();

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <style>
        .login-form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .login-form label {
            display: block;
            margin-bottom: 10px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .moto-list {
            margin-bottom: 20px;
        }

        .moto-list-item {
            margin-bottom: 10px;
        }

        .moto-list-item .moto-image {
            width: 100px;
            height: auto;
        }

        .moto-list-item .delete-button {
            width: 180px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

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

        .search-form {
            width: 300px;
            margin: 20px auto;
        }

        .search-form label {
            display: block;
            margin-bottom: 10px;
        }

        .search-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .search-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .select-style {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #f2f2f2;
            color: #000;
            cursor: pointer;
        }

        .select-style select {
            display: none;
        }

        .select-style select option {
            padding: 10px;
            background-color: #f2f2f2;
            color: #000;
        }

        .select-style .placeholder {
            color: #999;
        }

        .select-style .arrow-down {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .details-link {
            color: #4CAF50;
            font-weight: bold;
            text-decoration: none;
        }

        .details-link:hover {
            color: #4CAF50;
        }
    </style>
</head>
<body>
<?php if ($isLoggedIn) { ?>
    <div class="search-form">
        <form method="GET" action="index.php">
            <label for="search-type">Trier par type:</label>
            <select name="search-type" id="search-type">
                <option value="Enduro">Enduro</option>
                <option value="Custom">Custom</option>
                <option value="Sportive">Sportive</option>
                <option value="Roadster">Roadster</option>
            </select>
            <input type="submit" value="Rechercher">
        </form>
    </div>

    <?php
    // Récupérer et afficher la liste des motos
    $searchType = isset($_GET['search-type']) ? $_GET['search-type'] : null;

    $sql = "SELECT m.id, m.modele, m.type, m.image, ma.marque AS marque
            FROM motos m
            INNER JOIN marques ma ON m.marque_id = ma.id";

    if ($searchType) {
        $sql .= " WHERE m.type = '$searchType'";
    }

    $stmt = $db->getPDO()->query($sql);
    $motos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION['successMessage'])) {
        echo '<p style="color: green;">' . $_SESSION['successMessage'] . '</p>';

        unset($_SESSION['successMessage']);
    }

    if (!isset($_SESSION['deleteId'])) {
        $_SESSION['deleteId'] = null;
    }

    foreach ($motos as $moto) {
        echo '<div class="moto-list-item">';
        echo 'ID: ' . $moto['id'] . '<br>';
        echo 'Marque: ' . $moto['marque'] . '<br>';
        echo 'Modèle: ' . $moto['modele'] . '<br>';
        echo 'Type: ' . $moto['type'] . '<br>';
        echo 'Image: <img src="public/img/' . $moto['image'] . '" class="moto-image"><br>';

        // Afficher le lien "Détails"
        echo '<p><a href="View/details.php?moto_id=' . $moto['id'] . '" class="details-link">Détails</a></p>';

        if ($_SESSION['deleteId'] == $moto['id'] && $_SESSION['confirmDelete']) {
            echo '<p style="color: red; font-size: 12px;">Êtes-vous sûr de vouloir supprimer ?</p>';
            echo '<form method="GET" action="index.php">';
            echo '<input type="hidden" name="delete_id" value="' . $moto['id'] . '">';
            echo '<input type="submit" value="Confirmer la suppression" class="delete-button">';
            echo '</form>';
        } else {
            echo '<form method="GET" action="index.php">';
            echo '<input type="hidden" name="delete_id" value="' . $moto['id'] . '">';
            echo '<input type="submit" value="Supprimer" class="delete-button">';
            echo '</form>';
        }

        echo '</div>';
        echo '<hr>';
    }
    $marques = $motoManager->getAllBrands();
    ?>

    <!-- formulaire d'ajout de moto -->
    <div class="add-form">
        <form method="POST" action="Controller/add_moto.php">
            <label for="marque">Marque :</label>
            <select name="marque" id="marque" required>
                <?php foreach ($marques as $marque): ?>
                    <option value="<?php echo $marque['id']; ?>"><?php echo $marque['marque']; ?></option>
                <?php endforeach; ?>
            </select><br>

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
<?php } else { ?>
    <h1>Connexion</h1>
    <div class="login-form">
        <?php if (isset($loginError)) { ?>
            <p class="error-message"><?php echo $loginError; ?></p>
        <?php } ?>
        <form method="POST" action="index.php">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" value="Se connecter" class="login-button">
        </form>
    </div>
<?php } ?>
</body>
</html>




















