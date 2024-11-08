<?php
namespace Support;
class ServerStatusController
{
    // Fungsi statis untuk mendapatkan status server
    public static function getStatus()
    {
        // Mengambil beban CPU
        $cpuLoad = shell_exec("top -bn1 | grep 'Cpu(s)' | awk '{print $2 + $4}'");
        // Mengambil penggunaan memori
        $memoryUsage = shell_exec("free -m | awk '/Mem:/ { print $3 }'");
        // Mengambil penggunaan disk
        $diskUsage = shell_exec("df -h | awk '$NF==\"/\"{printf \"%d\", $5}'");

        // Mengembalikan data dalam bentuk array
        return [
            'cpu_load' => trim($cpuLoad),
            'memory_usage' => trim($memoryUsage),
            'disk_usage' => trim($diskUsage)
        ];
    }
}

