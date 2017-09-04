<?php

namespace Zan\Framework\Network\Http;

use ZanPHP\Framework\Foundation\Exception\ExceptionHandlerChain;
use ZanPHP\Contracts\Server\RequestExceptionHandlerChain as RequestExceptionHandlerChainContract;

class RequestExceptionHandlerChain extends ExceptionHandlerChain implements RequestExceptionHandlerChainContract
{
    public function init()
    {
        \ZanPHP\HttpServer\RequestExceptionHandlerChain::init();
    }
}
