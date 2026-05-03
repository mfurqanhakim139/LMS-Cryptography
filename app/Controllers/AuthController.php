<?php
namespace App\Controllers;
use App\Models\UserModel;
use Google_Client; // Dari library google/apiclient

class AuthController {
    // Fungsi Login Manual (Sudah ada, kita sesuaikan sedikit)
    public function login() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $user = (new UserModel())->getUserByEmail($data['email'] ?? '');

        if ($user && $user['password'] === ($data['password'] ?? '')) {
            echo json_encode(['status' => 'success', 'redirect' => $user['role'] === 'admin' ? 'admin/index.html' : 'user/dashboard.html']);
        } else {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Email atau password salah!']);
        }
    }

    // Fungsi Pendaftaran Manual
    public function register() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $model = new UserModel();
        if ($model->getUserByEmail($email)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Email sudah terdaftar!']);
            return;
        }

        if ($model->registerUser($name, $email, $password)) {
            echo json_encode(['status' => 'success', 'message' => 'Pendaftaran berhasil. Silakan login.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftar.']);
        }
    }
 public function googleAuth() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // 1. Masukkan Client ID persis seperti di gambar Anda
        $client = new Google_Client(['client_id' => '586513463671-8tat47p4ka17467n8l51fbsqrsg4pa07.apps.googleusercontent.com']);
        
        // 2. TAMBAHKAN DUA BARIS INI (BYPASS SSL / cURL ERROR)
        // Ini mengatasi error koneksi dari hosting ke server Google
        $guzzleClient = new \GuzzleHttp\Client(['verify' => false]);
        $client->setHttpClient($guzzleClient);
        
        // 3. Verifikasi Token
        $payload = $client->verifyIdToken($data['credential'] ?? '');

        if ($payload) {
            $model = new UserModel();
            $user = $model->getUserByEmail($payload['email']);
            
            // Jika belum terdaftar, otomatis daftarkan
            if (!$user) {
                $model->registerGoogleUser($payload['name'], $payload['email'], $payload['sub']);
                $user = $model->getUserByEmail($payload['email']); 
            }
            
            echo json_encode(['status' => 'success', 'redirect' => $user['role'] === 'admin' ? 'admin/index.html' : 'user/dashboard.html']);
        } else {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Token Google Tidak Valid']);
        }
    }   
    

   
}