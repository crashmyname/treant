<?php
namespace Support;

class Date{

    protected $time;

    public function __construct() {
        // Atur zona waktu ke Jakarta
        date_default_timezone_set('Asia/Jakarta');
    }
    
    public static function Now()
    {
        setTime();
        $date = date('Y-m-d H:i:s');
        return $date;
    }

    public static function Day()
    {
        setTime();
        $date = date('d');
        return $date;
    } 

    public static function Month()
    {
        setTime();
        $date = date('m');
        return $date;
    }

    public static function Year()
    {
        setTime();
        $date = date('Y');
        return $date;
    }

    public static function DayNow()
    {
        setTime();
        $date = date('l');
        return $date;
    }

    public static function DayName($dateInput = null)
    {
        // Pastikan timezone sudah diatur
        setTime();

        // Jika tidak ada input, gunakan tanggal hari ini
        $timestamp = $dateInput ? strtotime($dateInput) : time();

        // Dapatkan nama hari dalam bahasa Inggris
        $dayName = date('l', $timestamp);

        // Terjemahkan ke bahasa Indonesia (opsional)
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        return $days[$dayName] ?? $dayName; // Kembalikan dalam bahasa Indonesia jika tersedia
    }

    public static function parse($parameter)
    {
        $time = is_numeric($parameter) ? $parameter : strtotime($parameter);
        $instance = new self();
        $instance->time = $time;
        return $instance;
    }

    public function format($format)
    {
        return date($format,$this->time);
    }

    public function startOfDay()
    {
        setTime();
        return date('Y-m-d 00:00:00',$this->time);
    }

    public function endOfDay()
    {
        setTime();
        return date('Y-m-d 23:59:59',$this->time);
    }

    public static function isValidDateRange($date, $daysBefore = 14, $daysAfter = 14)
    {
        setTime();

        $today = date('Y-m-d');
        $minDate = date('Y-m-d', strtotime("-{$daysBefore} days"));
        $maxDate = date('Y-m-d', strtotime("+{$daysAfter} days"));

        return ($date >= $minDate && $date <= $maxDate);
    }
}