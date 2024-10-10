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
        $date = date('Y-m-d H:i:s');
        return $date;
    }

    public static function Day()
    {
        $date = date('d');
        return $date;
    } 

    public static function Month()
    {
        $date = date('m');
        return $date;
    }

    public static function Year()
    {
        $date = date('Y');
        return $date;
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
        return date('Y-m-d 00:00:00',$this->time);
    }

    public function endOfDay()
    {
        return date('Y-m-d 23:59:59',$this->time);
    }
}
?>