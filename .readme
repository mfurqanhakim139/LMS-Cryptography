# LMS Cryptography: End-to-End Encrypted Learning Platform

![GitHub repo size](https://img.shields.io/github/repo-size/mfurqanhakim139/LMS-Cryptography)
![GitHub top language](https://img.shields.io/github/languages/top/mfurqanhakim139/LMS-Cryptography)
![Security](https://img.shields.io/badge/Security-AES--256--GCM-green)

Repositori ini berisi *source code* lengkap untuk sistem Learning Management System (LMS) yang dilengkapi dengan arsitektur keamanan kriptografi *end-to-end* menggunakan algoritma **AES-256-GCM**. Proyek ini dikembangkan oleh CV Mitra Utama Teknologi sebagai bagian dari implementasi riset keamanan data pendidikan.

## 🚀 Fitur Utama
*   **End-to-End Encryption:** Seluruh *payload* data API dienkripsi di sisi server (PHP/OpenSSL) dan didekripsi di sisi *browser* klien (JavaScript Web Crypto API) tanpa mengorbankan performa.
*   **Asynchronous Content Delivery:** Memanfaatkan *fetch* API untuk memuat modul kursus secara *seamless*.
*   **User Progress Tracking:** Sistem pelacakan durasi tontonan video secara presisi.
*   **Certificate Generation:** Pembuatan E-Sertifikat otomatis (PDF) bagi peserta yang telah menyelesaikan kursus.

## 📂 Struktur Direktori
*   `/app`: Berisi inti *backend* MVC (Controllers, Models, Views) berbasis PHP.
*   `/public`: Direktori akar web (CSS, JS, *assets*, dan *entry point* `index.php`). File kriptografi klien berada di `/public/js/crypto_client.js`.
*   `composer.json` & `composer.lock`: Manajemen dependensi PHP (seperti DomPDF).
*   `database.sql`: Skema *database* MySQL untuk migrasi awal.

## ⚙️ Skema Database (ERD)
Sistem ini menggunakan struktur tabel relasional yang saling terintegrasi:
1.  `users`: Manajemen kredensial pengguna dan peran (admin/user).
2.  `courses`: Entitas utama kursus.
3.  `course_modules`: Sub-entitas dari kursus yang berisi materi/video.
4.  `user_progress`: Tabel transaksional untuk mencatat progres belajar per modul.
5.  `certificates`: Tabel pencatatan penerbitan sertifikat kelulusan.

## 🔬 Kinerja & Riset
Sistem ini telah diuji (*Stress Test & Benchmarking*) untuk memvalidasi bahwa enkripsi kriptografi AES-256-GCM tidak menyebabkan *bottleneck*. Kinerja sistem tetap stabil (tingkat keberhasilan 100%) meskipun dihantam 100 *request* konkuren, menjadikannya arsitektur yang ideal untuk aplikasi multi-pengguna dengan lalu lintas tinggi.

---
*Developed by Muhammad Furqan Hakim - Universitas Graha Karya Muara Bulian*
