<?php

namespace Zan\Framework\Network\Http\Middleware;


use ZanPHP\Contracts\Network\Request;
use ZanPHP\Contracts\Network\Response;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestTerminator;

class SessionTerminator implements RequestTerminator
{
    private $SessionTerminator;

    public function __construct()
    {
        $this->SessionTerminator = new \ZanPHP\HttpServer\Middleware\SessionTerminator();
    }

    public function terminate(Request $request, Response $response, Context $context)
    {
        $this->SessionTerminator->terminate($request, $response,$context);
    }
}