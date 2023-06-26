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

// Vérifier si un message de succès est présent dans la session
if (isset($_SESSION['successMessage'])) {
    echo '<p style="color: green;">' . $_SESSION['successMessage'] . '</p>';

    // Supprimer le message de succès de la session pour qu'il ne s'affiche qu'une fois
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

    // Ajouter le bouton "Détails"
    echo '<form method="GET" action="View/details.php">';
    echo '<input type="hidden" name="moto_id" value="' . $moto['id'] . '">';
    echo '<input type="submit" value="Détails" class="details-button">';
    echo '</form>';

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
