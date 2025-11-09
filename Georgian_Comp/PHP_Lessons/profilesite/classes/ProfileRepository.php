<?php
require_once __DIR__ . '/Database.php';

class ProfileRepository {
    public function create($name, $email, $bio, $image_path) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO profiles (name, email, bio, image_path) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $bio, $image_path]);
    }

    public function all() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM profiles ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function find($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM profiles WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
