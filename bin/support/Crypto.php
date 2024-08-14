<?php
namespace Support;
class Crypto
{
    private static $key = 'p@55w0rd';

    public static function encrypt($data)
    {
        $method = 'AES-256-CBC';
        $key = hash('sha256', self::$key, true);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
        return base64_encode($encrypted . '::' . bin2hex($iv));
    }

    public static function decrypt($data)
    {
        $method = 'AES-256-CBC';
        $key = hash('sha256', self::$key, true);
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, $method, $key, 0, hex2bin($iv));
    }
}

?>