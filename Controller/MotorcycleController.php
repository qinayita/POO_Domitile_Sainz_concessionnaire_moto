<?php

require_once 'Model/Class/Motorcycle.php';
require_once 'Model/Manager/MotoManager.php';

class MotorcycleController {
    private $motoManager;

    public function __construct() {
        $this->motoManager = new MotoManager();
    }

    public function listMotos() {
        $motos = $this->motoManager->getMotos();

        require_once 'View/listMotos.php';
    }

    public function addMoto($marque_id, $modele, $type, $image) {
        if (!$this->isLoggedIn()) {
            echo "Vous devez être connecté pour ajouter une moto.";
            return;
        }

        $this->motoManager->addMoto($marque_id, $modele, $type, $image);

        // TODO: Rediriger vers la liste des motos
    }

    public function viewMoto($id) {
        $moto = $this->motoManager->getMotoById($id);

        if (!$moto) {
            echo "Moto non trouvée.";
            return;
        }

        require_once 'View/viewMoto.php';
    }

    public function deleteMoto($id) {
        $this->motoManager->deleteMoto($id);

        // TODO: Rediriger vers la liste des motos
    }

    public function listMotosByType($type) {
        $motos = $this->motoManager->getMotosByType($type);

        require_once 'View/listMotos.php';
    }

    private function isLoggedIn() {
        return true;
    }
}







