<?php

namespace ZanPHP\HttpServer\ServerStart;

use ZanPHP\Contracts\Config\ConfigLoader;
use ZanPHP\Contracts\Config\Repository;
use ZanPHP\ServerBase\Middleware\MiddlewareInitiator;

class InitializeMiddleware
{
    private $zanFilters = [
        \Zan\Framework\Network\Http\Middleware\SessionFilter::class,
    ];

    private $zanTerminators = [
        \Zan\Framework\Network\Http\Middleware\SessionTerminator::class,
    ];

    /**
     * @param $server
     */
    public function bootstrap($server)
    {
        $repository = make(Repository::class);
        $middlewarePath = $repository->get('path.middleware');
        if (!is_dir($middlewarePath)) {
            return;
        }

        $middlewareInitiator = MiddlewareInitiator::getInstance();
        $configLoader = make(ConfigLoader::class);
        $middlewareConfig = $configLoader->load($middlewarePath);
        $exceptionHandlerConfig = isset($middlewareConfig['exceptionHandler']) ? $middlewareConfig['exceptionHandler'] : [];
        $exceptionHandlerConfig = is_array($exceptionHandlerConfig) ? $exceptionHandlerConfig : [];
        $middlewareConfig = isset($middlewareConfig['middleware']) ? $middlewareConfig['middleware'] : [];
        $middlewareConfig = is_array($middlewareConfig) ? $middlewareConfig : [];
        $middlewareInitiator->initConfig($middlewareConfig);
        $middlewareInitiator->initExceptionHandlerConfig($exceptionHandlerConfig);
        $middlewareInitiator->initZanFilters($this->zanFilters);
        $middlewareInitiator->initZanTerminators($this->zanTerminators);
    }
}
