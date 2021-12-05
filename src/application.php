<?php
namespace Base;
use \App\Controller;

class Application
{
    private $route;
    private $controllerName;
    private $actionName;

    public function __construct()
    {
        $this->route = new Route();
    }

    public function run()
    {
        try {
            $session = new Session();
            $session->Init();

            $this->addRoutes();
            $this->initController();
            $this->initAction();

            $content = $this->controllerName->{$this->actionName}();

            echo $content;
        } catch (Exception $e) {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }

    public function addRoutes()
    {
        $this->route->addRoute('/', \App\Controller\Blog::class, 'Index');
//        $this->route->addRoute('/blog/add', \App\Controller\Blog::class, 'Add');
//        $this->route->addRoute('/blog/remove', \App\Controller\Blog::class, 'Remove');
//
        $this->route->addRoute('/user', \App\Controller\User::class, 'Index');
        $this->route->addRoute('/user/', \App\Controller\User::class, 'Index');
        $this->route->addRoute('/user/auth', \App\Controller\User::class, 'Index');
        $this->route->addRoute('/user/registration', \App\Controller\User::class, 'Registration');
    }

    private function initController()
    {
        $controllerName = $this->route->getController();
        if (!class_exists($controllerName)) {
            header("HTTP/1.0 404 Not Found");
            die();
        }

        $this->controllerName = new $controllerName();
    }

    private function initAction()
    {
        $actionName = $this->route->getAction();
        if (!method_exists($this->controllerName, $actionName)) {
            throw new Exception('Action ' . $actionName . ' not found in ' . get_class($this->controllerName));
        }

        $this->actionName = $actionName;
    }
}
