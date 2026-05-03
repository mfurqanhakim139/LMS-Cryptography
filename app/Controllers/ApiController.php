<?php
namespace App\Controllers;
use App\Models\CertificateModel;
use Dompdf\Dompdf;

class ApiController {
    public function check() {
        header('Content-Type: application/json');
        $data = (new CertificateModel())->getStudentData($_GET['reg_number'] ?? '');
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => ['student' => $data['name'], 'course' => $data['course'], 'pdf_url' => 'api.php?ctrl=api&action=download&reg_number=' . $_GET['reg_number']]]);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Sertifikat tidak ditemukan']);
        }
    }
    public function download() {
        $data = (new CertificateModel())->getStudentData($_GET['reg_number'] ?? '');
        if ($data) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml("<h1>Sertifikat Kelulusan</h1><p>Nama: {$data['name']}</p><p>Kursus: {$data['course']}</p>");
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream('Sertifikat_'.$_GET['reg_number'].'.pdf', ['Attachment' => true]);
        }
    }
}