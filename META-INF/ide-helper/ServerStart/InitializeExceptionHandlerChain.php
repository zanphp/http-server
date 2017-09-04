<?php

namespace Zan\Framework\Network\Http\ServerStart;


class InitializeExceptionHandlerChain
{
    private $InitializeExceptionHandlerChain;

    public function __construct()
    {
        $this->InitializeExceptionHandlerChain = new \ZanPHP\HttpServer\ServerStart\InitializeExceptionHandlerChain();
    }

    public function bootstrap($server)
    {
        $this->InitializeExceptionHandlerChain->bootstrap($server);
    }
}
