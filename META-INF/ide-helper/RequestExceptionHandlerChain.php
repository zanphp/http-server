<?php

namespace Zan\Framework\Network\Http;

use ZanPHP\Framework\Foundation\Exception\ExceptionHandlerChain;
use ZanPHP\Contracts\Server\RequestExceptionHandlerChain as RequestExceptionHandlerChainContract;

class RequestExceptionHandlerChain extends ExceptionHandlerChain implements RequestExceptionHandlerChainContract
{
    private $RequestExceptionHandlerChain;

    public function __construct()
    {
        parent::__construct();
        $this->RequestExceptionHandlerChain = new \ZanPHP\HttpServer\RequestExceptionHandlerChain();
    }

    public function init()
    {
        $this->RequestExceptionHandlerChain->init();
    }
}
