<?php

class Request {
    private $data;

    public function __construct() {
        $this->data = array_merge($_GET, $_POST);
    }

    public function __get($key) {
        return $this->data[$key] ?? null;
    }

    public function all() {
        return $this->data;
    }
}
?>
