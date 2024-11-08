<?php

namespace Support;

use PDO;
use Support\Database;

class LogController {
    // Fungsi untuk menambahkan log dengan request dan response data
    public static function addLog($url, $httpMethod, $statusCode, $executionTime, $requestData = null, $responseData = null) {
        $db = Database::getConnection();
        
        // Cek apakah requestData dan responseData ada dan valid
        $requestData = $requestData ? json_encode($requestData) : null;
        $responseData = $responseData ? json_encode($responseData) : null;

        // Menyimpan log ke database
        $stmt = $db->prepare("INSERT INTO logs (url, http_method, status_code, execution_time, request_data, response_data) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$url, $httpMethod, $statusCode, $executionTime, $requestData, $responseData]);
    }

    // Fungsi untuk mendapatkan logs terbaru
    public static function getLogs() {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM logs ORDER BY created_at DESC LIMIT 10");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengambil log terbaru
    }
}
