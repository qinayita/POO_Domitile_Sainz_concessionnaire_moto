<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des motos</title>
</head>
<body>
<h1>Liste des motos</h1>

<form method="get" action="index.php">
    <input type="hidden" name="action" value="listByType">
    <label for="type">Tri par type :</label>
    <select name="type" id="type">
        <option value="Enduro">Enduro</option>
        <option value="Custom">Custom</option>
        <option value="Sportive">Sportive</option>
        <option value="Roadster">Roadster</option>
    </select>
    <button type="submit">Trier</button>
</form>

<?php foreach ($motos as $moto): ?>
    <h2>ID: <?php echo $moto['id']; ?></h2>
    <p>Marque ID: <?php echo $moto['marque_id']; ?></p>
    <p>Modèle: <?php echo $moto['modele']; ?></p>
    <p>Type: <?php echo $moto['type']; ?></p>
    <?php if (!empty($moto['image'])): ?>
        <img src="<?php echo $moto['image']; ?>" alt="Image de la moto">
    <?php endif; ?>
    <hr>
<?php endforeach; ?>
</body>
</html>

