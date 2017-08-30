<?php

namespace ZanPHP\HttpServer\ServerStart;

use ZanPHP\Container\Container;
use ZanPHP\HttpServer\RequestExceptionHandlerChain;
use ZanPHP\Contracts\Server\RequestExceptionHandlerChain as RequestExceptionHandlerChainContract;

class InitializeExceptionHandlerChain
{
    /**
     * @param \Zan\Framework\Network\Http\Server $server
     */
    public function bootstrap($server)
    {
        RequestExceptionHandlerChain::getInstance()->init();
        $container = Container::getInstance();
        $container->instance(RequestExceptionHandlerChainContract::class, RequestExceptionHandlerChain::getInstance());
    }
}
