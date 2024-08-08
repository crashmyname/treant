<?php

class View{

    public static function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . '/../../View/' . $view . '.php';
        // header("Location: $route");
        exit();
    }

    public static function redirectTo($route)
    {
        header("Location: $route");
        exit();
    }
}

?>