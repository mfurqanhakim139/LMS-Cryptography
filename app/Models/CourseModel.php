<?php
namespace App\Models;
use App\Config\Database;
use PDO;

class CourseModel {
    private $conn;
    public function __construct() { $this->conn = (new Database())->getConnection(); }

    public function getModules($courseId) {
        // Mengambil semua modul berdasarkan ID kursus, diurutkan dari yang pertama
        $stmt = $this->conn->prepare("SELECT * FROM course_modules WHERE course_id = :course_id ORDER BY sequence ASC");
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}