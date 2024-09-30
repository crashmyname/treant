<?php
namespace Support;

class View{

    private static $data = [];
    private static $errorHandler;

    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    public static function setErrorHandler($callback)
    {
        self::$errorHandler = $callback;
    }

    public static function render($view, $data = [], $layout = null)
    {
        extract($data);
        $viewPath = __DIR__ . '/../../View/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: $viewPath");
        }
        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        if ($layout) {
            $layoutPath = __DIR__ . '/../../View/' . $layout . '.php';
            if (file_exists($layoutPath)) {
                include $layoutPath;
            } else {
                // throw new Exception("Layout file not found: $layoutPath");
                View::render('errors/500');
            }
        } else {
            echo $content;
        }
        exit();
    }

    public static function redirectTo($route, $flashData = [])
    {
        // Store flash data in session
        if (!empty($flashData)) {
            $_SESSION['flash_data'] = $flashData;
        }
        $fullroute = $_ENV['ROUTE_PREFIX'].$route;
        header("Location: $fullroute");
        exit();
    }
}

?>