<?php
namespace Support;

use Config\Database;

class JobController
{
    private static $db;

    // Inisialisasi koneksi database statis
    public static function init()
    {
        self::$db = Database::getConnection();
    }

    // Fungsi statis untuk membuat job baru
    public static function createJob($name)
    {
        // Menambahkan job baru ke database
        $stmt = self::$db->prepare("INSERT INTO jobs (name, status) VALUES (?, 'waiting')");
        $stmt->execute([$name]);
    }

    // Fungsi statis untuk mengupdate status job
    public static function updateJobStatus($id, $status, $error_message = null)
    {
        $stmt = self::$db->prepare("UPDATE jobs SET status = ?, error_message = ?, finished_at = NOW() WHERE id = ?");
        $stmt->execute([$status, $error_message, $id]);
    }

    // Fungsi statis untuk mendapatkan semua job
    public static function getJobs()
    {
        // Dapatkan semua job dari database
        $stmt = self::$db->query("SELECT * FROM jobs ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

