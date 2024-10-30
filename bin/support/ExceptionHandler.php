<?php
namespace Support;

class ExceptionHandler
{
    public static function handle($exception)
    {
        // Tangkap pesan error dan kirim ke renderErrorPage
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        // Coba tampilkan error dalam format yang lebih user-friendly
        if ($message === 'Invalid CSRF token') {
            self::renderErrorPage(
                'Invalid Request',
                'The CSRF token provided is invalid. Please try again.',
                $exception
            );
        } else {
            self::renderErrorPage(
                'An error occurred',
                'Something went wrong: ' . $message,
                $exception
            );
        }
    }

    public static function renderErrorPage($title, $message, $exception)
    {
        // Pastikan path yang digunakan untuk view error ada
        $viewPath = realpath(__DIR__ . '/../../app/Handle/errors/page_error.php');
        
        // Debugging: Jika viewPath kosong, tampilkan pesan error
        if (!$viewPath) {
            echo "Error: View path for error page is not found.";
            exit;
        }

        // Include halaman error
        include $viewPath;
        exit();
    }
}


?>