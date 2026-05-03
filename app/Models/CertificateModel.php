<?php
namespace App\Models;
use App\Config\Database;
use PDO;

class CertificateModel {
    private $conn;
    public function __construct() { $this->conn = (new Database())->getConnection(); }

    public function getStudentData($regNumber) {
        $query = "SELECT u.name, c.title as course, cert.score, cert.issued_date 
                  FROM certificates cert
                  JOIN users u ON cert.user_id = u.id
                  JOIN courses c ON cert.course_id = c.id
                  WHERE cert.reg_number = :reg_number LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':reg_number', $regNumber);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}