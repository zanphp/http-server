<?php

namespace Zan\Framework\Network\Http\Middleware;


use ZanPHP\Contracts\Network\Request;
use ZanPHP\Contracts\Network\Response;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestTerminator;

class SessionTerminator implements RequestTerminator
{
    public function terminate(Request $request, Response $response, Context $context)
    {
        \ZanPHP\HttpServer\Middleware\SessionTerminator::terminate($request, $response,$context);
    }
}