<?php
namespace App\Helpers;

class SecurityHelper {
    // Kunci rahasia 32-byte (256-bit)
// app/Helpers/SecurityHelper.php
private static $secretKey = 'EduPortal_Q1_Research_Key_32Byte'; 
private static $method = 'aes-256-gcm';

    public static function encrypt($data) {
        $startTime = microtime(true);

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-gcm'));
        $tag = "";
        
        $plaintext = is_array($data) ? json_encode($data) : $data;

        $ciphertext = openssl_encrypt($plaintext, 'aes-256-gcm', self::$secretKey, OPENSSL_RAW_DATA, $iv, $tag);

        $endTime = microtime(true);

        return [
            'payload' => base64_encode($ciphertext),
            'iv' => base64_encode($iv),
            'tag' => base64_encode($tag),
            'benchmark_ms' => ($endTime - $startTime) * 1000 // Data metrik Q1
        ];
    }

    public static function decrypt($encryptedPayload, $ivBase64, $tagBase64) {
        $startTime = microtime(true);

        $ciphertext = base64_decode($encryptedPayload);
        $iv = base64_decode($ivBase64);
        $tag = base64_decode($tagBase64);

        $plaintext = openssl_decrypt($ciphertext, 'aes-256-gcm', self::$secretKey, OPENSSL_RAW_DATA, $iv, $tag);

        $endTime = microtime(true);
        $result = json_decode($plaintext, true) ?? $plaintext;

        return [
            'data' => $result,
            'benchmark_ms' => ($endTime - $startTime) * 1000
        ];
    }
}
