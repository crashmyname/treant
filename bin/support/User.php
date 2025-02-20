<?php
namespace Support;

class User {
    private $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function __get($key) {
        return $this->data[$key] ?? null;
    }
}
