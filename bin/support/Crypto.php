<?php
namespace Support;

class Crypto
{
    private static $key = env('CRYPTO_SECRET');

    public static function encrypt($data)
    {
        $method = 'AES-256-CBC';
        $key = hash('sha256', self::$key, true);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
        return self::base64UrlEncode($encrypted . '::' . bin2hex($iv));
    }

    public static function decrypt($data)
    {
        $method = 'AES-256-CBC';
        $key = hash('sha256', self::$key, true);
        
        // Decode data dari URL-safe Base64
        $decodedData = self::base64UrlDecode($data);
        
        // Memisahkan data terenkripsi dan IV
        $parts = explode('::', $decodedData, 2);
        
        if (count($parts) !== 2) {
            // Jika tidak ada dua bagian, berarti data tidak valid
            return false; // atau throw exception sesuai kebutuhan
        }
        
        list($encrypted_data, $iv) = $parts;
        
        // Dekripsi data
        return openssl_decrypt($encrypted_data, $method, $key, 0, hex2bin($iv));
    }

    private static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode($data)
    {
        $data .= str_repeat('=', (4 - strlen($data) % 4) % 4); // Tambahkan padding jika perlu
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
?>