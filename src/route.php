<?php
namespace Base;

class Route
{
    private $controllerName;
    private $actionName;
    private $is_processed = false;
    private $routes = [];

    public function process()
    {
        if ($this->is_processed === true) {
            return;
        }

        $path = parse_url($_SERVER['REQUEST_URI']);
        $path = $path['path'];

        if (($route = $this->routes[$path] ?? null) !== null) {
            $this->controllerName = $route['0'];
            $this->actionName = $route['1'];
        } else {
            $paths = explode('/', $path);
            $this->controllerName = '\\App\\Controller\\' . $paths[1];
            $this->actionName = $paths[2] ?? 'Index';
        }

        $this->is_processed = true;
    }

    public function addRoute($path, $controller, $action)
    {
        $this->routes[$path] = [
            $controller,
            $action
        ];
    }

    public function getController()
    {
        if ($this->is_processed === false) {
            $this->process();
        }

        return $this->controllerName;
    }

    public function getAction()
    {
        if ($this->is_processed === false) {
            $this->process();
        }

        return $this->actionName;
    }
}