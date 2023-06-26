<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Détails de la moto</title>
</head>
<body>
<h1>Détails de la moto</h1>

<?php if ($moto): ?>
    <h2>ID: <?php echo $moto['id']; ?></h2>
    <p>Marque ID: <?php echo $moto['marque_id']; ?></p>
    <p>Modèle: <?php echo $moto['modele']; ?></p>
    <p>Type: <?php echo $moto['type']; ?></p>
    <?php if (!empty($moto['image'])): ?>
        <img src="<?php echo $moto['image']; ?>" alt="Image de la moto">
    <?php endif; ?>
<?php else: ?>
    <p>Moto non trouvée.</p>
<?php endif; ?>
</body>
</html>
