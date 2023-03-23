<?php

namespace App\Core\Requests;

class Request
{
    public $body = [];
    public $params = [];
    public $query = [];

    public function __construct()
    {
        if (in_array($this->getMethod(), ["GET", "HEAD"])) {
            $this->query = $this->sanitizeGetData($_GET);
        }

        if (in_array($this->getMethod(), ["POST", "PUT", "PATCH", "DELETE"])) {
            $this->query = $this->sanitizeGetData($_GET);
            $this->body = $this->sanitizePostData($_POST);
        }
    }

    private function sanitizeGetData($get)
    {
        $sanitized = [];

        foreach ($get as $key => $value) {
            $sanitized[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $sanitized;
    }

    private function sanitizePostData($post)
    {
        $sanitized = [];

        foreach ($post as $key => $value) {
            $sanitized[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $sanitized;
    }

    public function getMethod()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($path, '?')) {
            $path = substr($path, 0, $pos);
        }
        $path = rawurldecode($path);
        return $path;
    }

    public function getURI()
    {
        return $_SERVER["uri"];
    }
}