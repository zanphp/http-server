<?php

namespace ZanPHP\HttpServer;

use ZanPHP\Framework\Foundation\Exception\ExceptionHandlerChain;
use ZanPHP\Contracts\Server\RequestExceptionHandlerChain as RequestExceptionHandlerChainContract;
use ZanPHP\HttpFoundation\Exception\Handler\InternalErrorHandler;
use ZanPHP\HttpFoundation\Exception\Handler\InvalidRouteHandler;
use ZanPHP\HttpFoundation\Exception\Handler\PageNotFoundHandler;
use ZanPHP\HttpFoundation\Exception\Handler\RedirectHandler;
use ZanPHP\HttpFoundation\Exception\Handler\ServerUnavailableHandler;
use ZanPHP\HttpServer\Exception\Handler\BizErrorHandler;
use ZanPHP\HttpServer\Exception\Handler\ForbiddenHandler;
use ZanPHP\Support\Singleton;

class RequestExceptionHandlerChain extends ExceptionHandlerChain implements RequestExceptionHandlerChainContract
{
    use Singleton;

    private $handles = [
        RedirectHandler::class,
        PageNotFoundHandler::class,
        ForbiddenHandler::class,
        InvalidRouteHandler::class,
        BizErrorHandler::class,
        ServerUnavailableHandler::class,
        InternalErrorHandler::class,
    ];

    public function init()
    {
        $this->addHandlersByName($this->handles);
    }
}
