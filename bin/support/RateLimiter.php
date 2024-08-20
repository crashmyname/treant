<?php
namespace Support;

class RateLimiter
{
    private $limit = 500; // Jumlah maksimum permintaan
    private $timeFrame = 3600; // Jangka waktu dalam detik (misalnya 1 jam)
    private $requests = [];

    public function __construct() {
        // Inisialisasi jika belum ada data
        if (!isset($_SESSION['requests'])) {
            $_SESSION['requests'] = [];
        }
        $this->requests = &$_SESSION['requests'];
    }

    public function check($ipAddress) {
        $now = time();
        if (!isset($this->requests[$ipAddress])) {
            $this->requests[$ipAddress] = [];
        }

        // Hapus permintaan yang sudah terlalu lama
        $this->requests[$ipAddress] = array_filter($this->requests[$ipAddress], function($timestamp) use ($now) {
            return ($now - $timestamp) < $this->timeFrame;
        });

        // Cek apakah melebihi batas
        if (count($this->requests[$ipAddress]) >= $this->limit) {
            return false; // Limit exceeded
        }

        // Catat permintaan baru
        $this->requests[$ipAddress][] = $now;
        return true; // Limit not exceeded
    }
}
?>