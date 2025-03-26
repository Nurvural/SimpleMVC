<?php

class TemplateEngine
{

    public function render($viewPath, $data = [])
    {
        extract($data);

        $viewPath = __DIR__ . '/../app/' . $viewPath;

        if (!file_exists($viewPath)) {
            die("View file not found:" . $viewPath);
        }

        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        return $content;
    }
}
