<?php

class Controller
{
    private $content;
    protected $layout = 'layout';
    protected $title = '';
    protected $description = '';
    
    protected function render($_view, $_dataParameters)
    {
        $_viewPath = Router::$router->getAppPath() . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $_view . '.php';
        ob_start();
        extract($_dataParameters, EXTR_SKIP);
        require_once $_viewPath;
        
        $this->content = ob_get_clean();
        
        $_layoutPath = Router::$router->getAppPath() . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $this->layout . '.php';
        
        require $_layoutPath;
        
    }
}