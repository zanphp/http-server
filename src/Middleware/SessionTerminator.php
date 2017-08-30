<?php

namespace ZanPHP\HttpServer\Middleware;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Contracts\Network\Response;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestTerminator;

class SessionTerminator implements RequestTerminator
{
    public function terminate(Request $request, Response $response, Context $context)
    {
        $session = $context->get('session');
        if (!$session) {
            return;
        }

        yield $session->writeBack();
    }
}