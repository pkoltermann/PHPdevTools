<?php
class Router
{
    protected $basePath;
    protected $activeController;
    protected $activeAction = 'index';
    protected $config;
    public static $router = null; 
    
    public function __construct()
    {
        if (Router::$router) {
            return Router::$router;
        }
        Router::$router = $this;
        
        $this->basePath = dirname(__DIR__);
        $this->includeBaseClasses();
        $this->config = $this->getConfig();
        $this->activeController = $this->config['defaultController'];
        $this->setActiveControllerAndAction();
    }
    
    protected function getConfig()
    {
        return include($this->getAppPath() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
    }
    
    protected function includeBaseClasses()
    {
        $controllerPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Controller.php';
        require $controllerPath;
        $modelPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Model.php';
        require $modelPath;
    }
    
    protected function setActiveControllerAndAction()
    {
        $requestUri = (!empty($_GET['r'])) ? $_GET['r'] : false;
        if (!$requestUri) {
            return;
        }
        $matches = null;
        $mask = '/^([\w\-]*)/';
        $requestValid = preg_match($mask, $requestUri, $matches);
        if ($requestValid) {
            if (!empty($matches[1])) {
                $this->extractUrlData($matches[1]);
            }
        } else {
            $this->route404();
        }
    }
    
    protected function extractUrlData($url) {
        $matches = preg_split('/\//', $url);
        if (count($matches) > 0) {
            $this->activeController = $matches[0];
            if (!empty($matches[1])) {
                $this->activeAction = $matches[1];
            }
        }
    }
        
    function getBasePath() {
        return $this->basePath;
    }
    
    function getAppPath() {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'app';
    }
    
    public function route()
    {
        $action = 'action' . ucfirst($this->activeAction);
        $controller = $this->activeController . 'Controller';
        $this->includeControllerClass();
        $controller = new $controller();
        $controller->$action();
    }
    
    protected function includeControllerClass()
    {
        $controllerPath = $this->getAppPath() . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . ucfirst($this->activeController) . 'Controller.php';
        require $controllerPath;
    }
    
    public static function includeModel($model)
    {
        $modelPath = Router::$router->getAppPath() . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . ucfirst($model) . 'Model.php';
        require_once $modelPath;
    }
}