<?php
namespace App\Config;
use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    
    // 1. UBAH NAMA DATABASE DI SINI
    private $db_name = 'mitra432_kursus'; 
    
    // 2. SESUAIKAN USERNAME DAN PASSWORD
    // Jika Anda menggunakan XAMPP lokal, biarkan 'root' dan password kosong ''.
    // TAPI jika ini di cPanel/Hosting, isi dengan username & password database cPanel Anda!
    private $username = 'mitra432_root'; 
    private $password = '20061996Lk#'; 
    
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Agar jika error, ketahuan masalahnya apa di tab Network Inspect Element
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Koneksi DB Gagal: ' . $exception->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}