<?php
namespace App\Controllers;

use App\Helpers\SecurityHelper;
use App\Config\Database;
use PDO;

class CourseController {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    // ==========================================
    // FUNGSI UNTUK PLAYER VIDEO (GET MODULES)
    // ==========================================
    public function getModules() {
        $course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 1;
        
        try {
            $stmt = $this->conn->prepare("SELECT * FROM course_modules WHERE course_id = ? ORDER BY sequence ASC");
            $stmt->execute([$course_id]);
            $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Start Q1 Benchmark
            $start = microtime(true);
            $encryptedData = SecurityHelper::encrypt($modules);
            $end = microtime(true);
            
            $benchmark_ms = ($end - $start) * 1000;
            
            echo json_encode([
                'status' => 'success',
                'data' => $encryptedData,
                'benchmark_ms' => $benchmark_ms
            ]);
        } catch (\PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
        }
    }

    // ==========================================
    // FUNGSI UNTUK DASBOR MAHASISWA (GET COURSES)
    // ==========================================
    public function getAllCourses() {
        try {
            // Tarik data kursus dari database MySQL
            $stmt = $this->conn->prepare("SELECT id, title, description FROM courses ORDER BY id DESC");
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Enkripsi AES-256-GCM sebelum dikirim ke browser
            $encryptedData = SecurityHelper::encrypt($courses);

            echo json_encode(['status' => 'success', 'data' => $encryptedData]);
        } catch (\PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
        }
    }
}
