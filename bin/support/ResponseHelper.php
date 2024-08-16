<?php
namespace Support;

class ResponseHelper
{
    public static function json($data, $status = 200)
    {
        header('Content-Type: application/json', true, $status);
        echo json_encode($data);
        exit; // Ensure no further processing happens
    }
    public static function success($message = 'Operation successful', $status = 200)
    {
        return self::json(['success' => true, 'message' => $message], $status);
    }

    public static function error($message = 'Operation failed', $status = 400)
    {
        return self::json(['success' => false, 'message' => $message], $status);
    }
}

?>