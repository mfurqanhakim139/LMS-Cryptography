<?php
// Izinkan error reporting saat development (opsional)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Pastikan lokasi vendor autoload sudah benar
require_once __DIR__ . '/../vendor/autoload.php';

// Wajib set header ke JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Mencegah blokir CORS saat hosting

$ctrl = $_GET['ctrl'] ?? '';
$action = $_GET['action'] ?? '';

// ==========================================
// ROUTER UTAMA
// ==========================================

// Rute Autentikasi
if ($ctrl === 'auth' && $action === 'login') {
    (new App\Controllers\AuthController())->login();
} 
elseif ($ctrl === 'auth' && $action === 'register') {
    (new App\Controllers\AuthController())->register();
} 
elseif ($ctrl === 'auth' && $action === 'google') {
    (new App\Controllers\AuthController())->googleAuth();
} 

// Rute API General / Certificate
elseif ($ctrl === 'api' && $action === 'check') {
    (new App\Controllers\ApiController())->check();
} 
elseif ($ctrl === 'api' && $action === 'download') {
    (new App\Controllers\ApiController())->download();
} 

// Rute Course / Mahasiswa
elseif ($ctrl === 'course' && $action === 'get_modules') {
    (new App\Controllers\CourseController())->getModules();
}
elseif ($ctrl === 'course' && $action === 'get_all_courses') {
    (new App\Controllers\CourseController())->getAllCourses();
}

// ==========================================
// RUTE PANEL ADMIN (SUPER PENTING)
// ==========================================
elseif ($ctrl === 'admin' && $action === 'get_courses') {
    (new App\Controllers\AdminController())->getCourses();
}
elseif ($ctrl === 'admin' && $action === 'add_course') {
    (new App\Controllers\AdminController())->addCourse();
}
// INI DIA YANG HILANG SEBELUMNYA!
elseif ($ctrl === 'admin' && $action === 'upload_module') {
    (new App\Controllers\AdminController())->uploadModule();
}
elseif ($ctrl === 'admin' && $action === 'update_module') {
    (new App\Controllers\AdminController())->updateModule();
}
elseif ($ctrl === 'admin' && $action === 'delete_module') {
    (new App\Controllers\AdminController())->deleteModule();
}

// Fallback Jika Rute Tidak Ditemukan
else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint API tidak ditemukan']);
}