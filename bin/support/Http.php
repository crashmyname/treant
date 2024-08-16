<?php
namespace Support;

class Http
{
    public static function get($url, $headers = [])
    {
        return self::request('GET', $url, null, $headers);
    }

    public static function post($url, $data = [], $headers = [])
    {
        return self::request('POST', $url, $data, $headers);
    }

    public static function put($url, $data = [], $headers = [])
    {
        return self::request('PUT', $url, $data, $headers);
    }

    public static function delete($url, $data = [], $headers = [])
    {
        return self::request('DELETE', $url, $data, $headers);
    }

    private static function request($method, $url, $data = null, $headers = [])
    {
        // Gunakan cURL
        $ch = curl_init();

        // Set opsi cURL umum
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Set data untuk POST, PUT, DELETE
        if ($data) {
            $jsonData = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Content-Length: ' . strlen($jsonData);
        }

        // Set header jika ada
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Eksekusi cURL dan ambil hasilnya
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Periksa apakah ada error
        if (curl_errno($ch)) {
            throw new \Exception('Request Error: ' . curl_error($ch));
        }

        curl_close($ch);

        // Kembalikan hasil sebagai array dengan status kode HTTP
        return [
            'status' => $httpCode,
            'response' => json_decode($result, true),
        ];
    }
}
?>