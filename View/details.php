<?php
require_once '../Model/Manager/DbManager.php';
require_once '../Model/Manager/MotoManager.php';
require_once '../autoload.php';

$db = new DbManager();
$motoManager = new MotoManager();

if (isset($_GET['moto_id'])) {
    $motoId = $_GET['moto_id'];

    $moto = $motoManager->getMotoById($motoId);

    if ($moto) {
        include 'parts/header.php';
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>Détails de la moto</title>
            <style>
            </style>
        </head>
        <body>
        <div>
            <h1 style="display: inline-block;">Détails de la moto</h1>
            <a href="../index.php" style="display: inline-block; margin-left: 10px;">Retour</a>
        </div>
        <div>
            <img src="../public/img/<?php echo $moto['image']; ?>" alt="Moto">
            <p>Marque: <?php echo $moto['marque']; ?></p>
            <p>Modèle: <?php echo $moto['modele']; ?></p>
            <p>Type: <?php echo $moto['type']; ?></p>
        </div>
        </body>
        </html>

        <?php
        exit;
    }
}

header('Location: error.php');
exit;
?>






