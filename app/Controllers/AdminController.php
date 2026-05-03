<?php
namespace App\Controllers;

use App\Helpers\SecurityHelper;
use App\Config\Database;
use PDO;

class AdminController {
    private $conn;

    public function __construct() { 
        $this->conn = (new Database())->getConnection(); 
    }

    // ==========================================
    // 1. STATISTIK DASBOR (Dienkripsi)
    // ==========================================
    public function getDashboardStats() {
        // Simulasi data statistik. Nanti bisa diganti dengan query COUNT() asli.
        $dashboardData = [
            'stats' => [
                'total_students' => 142, 
                'active_courses' => 8, 
                'total_certificates' => 85, 
                'server_ping' => rand(10, 25) . 'ms'
            ],
            'recent_registrations' => [
                ['name' => 'Arga Chon Feriandref', 'email' => 'arga@student.ac.id', 'method' => 'Google', 'status' => 'Aktif'],
                ['name' => 'Muhammad Furqan Hakim', 'email' => 'furqan@dosen.ac.id', 'method' => 'Manual', 'status' => 'Aktif']
            ]
        ];

        // Enkripsi Payload untuk standar riset Q1
        $encryptedData = SecurityHelper::encrypt($dashboardData);
        
        echo json_encode([
            'status' => 'success', 
            'data' => $encryptedData
        ]);
    }

    // ==========================================
    // 2. DAFTAR KURSUS (Dienkripsi)
    // ==========================================
    public function getCourses() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM courses ORDER BY id DESC");
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Enkripsi data kursus
            $encryptedData = SecurityHelper::encrypt($courses);
            
            echo json_encode(['status' => 'success', 'data' => $encryptedData]);
        } catch (\PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
        }
    }

    // ==========================================
    // 3. TAMBAH KURSUS BARU
    // ==========================================
    public function addCourse() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($title)) {
            echo json_encode(['status' => 'error', 'message' => 'Judul kursus wajib diisi.']);
            return;
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO courses (title, description) VALUES (?, ?)");
            if ($stmt->execute([$title, $description])) {
                echo json_encode(['status' => 'success', 'message' => 'Kursus berhasil ditambahkan!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan kursus.']);
            }
        } catch (\PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
        }
    }

    // ==========================================
    // 4. UPLOAD VIDEO MODUL
    // ==========================================
    public function uploadModule() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid.']);
            return;
        }

        $course_id = (int)($_POST['course_id'] ?? 1);
        $title = $_POST['title'] ?? 'Modul Tanpa Judul';
        $sequence = (int)($_POST['sequence'] ?? 1);
        $duration = (int)($_POST['duration'] ?? 0);

        if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            
            $uploadDir = __DIR__ . '/../../public/uploads/videos/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $originalName = basename($_FILES['video']['name']);
            $cleanName = preg_replace('/[^A-Za-z0-9.\-]/', '_', $originalName);
            $fileName = time() . '_' . $cleanName;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['video']['tmp_name'], $targetPath)) {
                $videoUrl = '../uploads/videos/' . $fileName;

                try {
                    $stmt = $this->conn->prepare("INSERT INTO course_modules (course_id, title, sequence, duration_seconds, video_url) VALUES (?, ?, ?, ?, ?)");
                    
                    if ($stmt->execute([$course_id, $title, $sequence, $duration, $videoUrl])) {
                        echo json_encode(['status' => 'success', 'message' => 'Video berhasil diupload!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan ke database.']);
                    }
                } catch (\PDOException $e) {
                    echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memindahkan file ke folder uploads.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File video tidak valid atau melebihi limit ukuran server.']);
        }
    }

    // ==========================================
    // 5. UPDATE DATA MODUL (EDIT)
    // ==========================================
    public function updateModule() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $sequence = (int)($_POST['sequence'] ?? 0);
        $duration = (int)($_POST['duration'] ?? 0);

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID Modul tidak ditemukan.']);
            return;
        }

        try {
            $stmt = $this->conn->prepare("UPDATE course_modules SET title=?, sequence=?, duration_seconds=? WHERE id=?");
            if ($stmt->execute([$title, $sequence, $duration, $id])) {
                echo json_encode(['status' => 'success', 'message' => 'Data modul berhasil diperbarui.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui database.']);
            }
        } catch (\PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
        }
    }

    // ==========================================
    // 6. HAPUS MODUL (DELETE)
    // ==========================================
    public function deleteModule() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        
        $id = $_POST['id'] ?? null;
        if (!$id) return;

        try {
            // (Opsional) Ambil URL video untuk menghapus file fisiknya
            $stmtGet = $this->conn->prepare("SELECT video_url FROM course_modules WHERE id=?");
            $stmtGet->execute([$id]);
            $module = $stmtGet->fetch(PDO::FETCH_ASSOC);

            if ($module && strpos($module['video_url'], '../uploads/videos/') === 0) {
                // Hapus file fisik jika ada di server lokal
                $filePath = __DIR__ . '/../../public/' . ltrim($module['video_url'], '../');
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus record dari database
            $stmt = $this->conn->prepare("DELETE FROM course_modules WHERE id=?");
            if ($stmt->execute([$id])) {
                echo json_encode(['status' => 'success', 'message' => 'Modul dan file video berhasil dihapus.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus modul dari database.']);
            }
        } catch (\PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
        }
    }
}