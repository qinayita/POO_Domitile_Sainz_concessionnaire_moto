<?php

require_once 'DbManager.php';

class UserManager extends DbManager {
    public function verifyAndHashPasswords() {
        $sql = "SELECT id, mot_de_passe FROM utilisateur";
        $stmt = $this->pdo->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            $userId = $user['id'];
            $password = $user['mot_de_passe'];

            if (!password_needs_rehash($password, PASSWORD_DEFAULT)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "UPDATE utilisateur SET mot_de_passe = ? WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$hashedPassword, $userId]);
            }
        }

        $adminPassword = 'admin';
        $adminHashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE utilisateur SET mot_de_passe = ? WHERE nom_utilisateur = 'admin'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$adminHashedPassword]);
    }

    public function verifyCredentials($username, $password) {
        $sql = "SELECT id, mot_de_passe FROM utilisateur WHERE nom_utilisateur = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['mot_de_passe'])) {
                return true;
            }
        }

        return false;
    }
}


