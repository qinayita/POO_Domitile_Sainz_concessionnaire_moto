<?php
require_once __DIR__ . '/DbManager.php';


class MotoManager extends DbManager {
    public function authenticateUser($username, $password) {
        $user = $this->getUserByUsername($username);

        if (!$user) {
            return false;
        }

        $hashedPassword = $user['password'];

        if (password_verify($password, $hashedPassword)) {
            return true;
        }

        return false;
    }

    public function addMoto($marque_id, $modele, $type, $image = null) {
        $sql = "INSERT INTO motos (marque_id, modele, type, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$marque_id, $modele, $type, $image]);
        return $this->pdo->lastInsertId();
    }

    public function getMotos() {
        $sql = "SELECT * FROM motos";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllMotos() {
        return $this->getMotos();
    }

    public function getMotoById($id) {
        $sql = "SELECT m.*, ma.marque AS marque FROM motos m INNER JOIN marques ma ON m.marque_id = ma.id WHERE m.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteMoto($id) {
        $sql = "DELETE FROM motos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    public function updateMoto($id, $marque_id, $modele, $type, $image = null) {
        $sql = "UPDATE motos SET marque_id = ?, modele = ?, type = ?, image = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$marque_id, $modele, $type, $image, $id]);
        return $stmt->rowCount();
    }

    public function getAllBrands() {
        $sql = "SELECT id, marque FROM marques";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}








