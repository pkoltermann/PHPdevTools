<?php

class Controller
{
    private $content;
    protected $layout = 'layout';
    protected $title = '';
    protected $description = '';
    
    protected function render($view, $data)
    {
        $viewPath = Router::$router->getAppPath() . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $view . '.php';
        ob_start();
        extract($data, EXTR_SKIP);
        require_once $viewPath;
        
        $this->content = ob_get_clean();
        
        $layoutPath = Router::$router->getAppPath() . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $this->layout . '.php';
        
        require $layoutPath;
        
    }
}