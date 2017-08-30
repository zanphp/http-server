<?php

namespace ZanPHP\HttpServer;

use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Contracts\Foundation\Application;
use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\HttpFoundation\Exception\PageNotFoundException;

class Dispatcher
{
    public function dispatch(Request $request, Context $context)
    {
        $controllerName = $context->get('controller_name');
        $action = $context->get('action_name');
        $args   = $context->get('action_args');

        if ($args == null) {
            $args = [];
        }

        $controller = $this->getControllerClass($controllerName);
        if(!class_exists($controller)) {
            throw new PageNotFoundException("controller:{$controller} not found");
        }

        $controller = new $controller($request, $context);
        if(!is_callable([$controller, $action])) {
            throw new PageNotFoundException("action:{$action} is not callable in controller:" . get_class($controller));
        }
        yield $controller->$action(...array_values($args));
    }

    private function getControllerClass($controllerName)
    {
        $parts = array_filter(explode('/', $controllerName));
        $controllerName = join('\\', array_map('ucfirst', $parts));
        $app = make(Application::class);
        $repository = make(Repository::class);
        $controllerRootNamespace = $repository->get('controller_mapping.root_namespace', $app->getNamespace());
        return $controllerRootNamespace . 'Controller\\' .  $controllerName . 'Controller';
    }
}
