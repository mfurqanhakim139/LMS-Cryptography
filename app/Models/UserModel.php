<?php
namespace App\Models;
use App\Config\Database;
use PDO;

class UserModel {
    private $conn;
    public function __construct() { $this->conn = (new Database())->getConnection(); }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Pendaftaran Manual
    public function registerUser($name, $email, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'user')");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    // Pendaftaran via Google
    public function registerGoogleUser($name, $email, $googleId) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, google_id, role) VALUES (:name, :email, :google_id, 'user')");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':google_id', $googleId);
        return $stmt->execute();
    }
}