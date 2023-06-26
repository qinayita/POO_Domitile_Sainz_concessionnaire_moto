<?php
// delete_moto.php

// Inclure les fichiers nécessaires
require_once 'Model/Manager/DbManager.php';
require_once 'Model/Manager/MotoManager.php';
require_once 'autoload.php';

// Initialiser le gestionnaire de base de données et de motos
$db = new DbManager();
$motoManager = new MotoManager();

// Vérifier si l'ID de la moto à supprimer a été fourni
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['moto_id'])) {
    // Récupérer l'ID de la moto à supprimer
    $motoId = $_POST['moto_id'];

    // Supprimer la moto
    $motoManager->deleteMoto($motoId);

    // Rediriger vers la page d'origine (index.php)
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    if (isset($_SESSION['confirmDelete']) && $_SESSION['confirmDelete'] === true && $_SESSION['deleteId'] === $deleteId) {
        $motoManager->deleteMoto($deleteId);

        $_SESSION['confirmDelete'] = false;
        $_SESSION['deleteId'] = null;

        header('Location: index.php');
        exit;
    } else {
        $_SESSION['confirmDelete'] = true;
        $_SESSION['deleteId'] = $deleteId;

        header('Location: index.php');
        exit;
    }
}

?>


