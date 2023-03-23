<?php

namespace App\Core\Responses;

class Response
{
    const DEFAULT_LAYOUT = 'default';
    private $layout = self::DEFAULT_LAYOUT;

    public function setStatusCode($code)
    {
        http_response_code($code);
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function redirect(string $path)
    {
        header("Location: $path");
        exit;
    }

    public function renderView(string $view, $params = [])
    {
        $viewContent = $this->getViewContent($view, $params);

        if ($this->layout) {
            $layoutContent = $this->getLayoutContent();
            echo str_replace("{{content}}", $viewContent, $layoutContent);
        } else {
            echo $viewContent;
        }
    }

    protected function getViewContent($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require_once __DIR__ . "/../../Presentation/Views/" . str_replace(".", "/", $view) . ".php";
        return ob_get_clean();
    }

    protected function getLayoutContent()
    {
        ob_start();
        require_once __DIR__ . "/../../Presentation/Layouts/" . str_replace(".", "/", $this->layout) . ".php";
        return ob_get_clean();
    }
}