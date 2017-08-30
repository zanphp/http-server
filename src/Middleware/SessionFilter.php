<?php

namespace ZanPHP\HttpServer\Middleware;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestFilter;

class SessionFilter implements RequestFilter
{
    public function doFilter(Request $request, Context $context)
    {
        $session = new Session($request, $context->get('cookie'));
        $res = (yield $session->init());
        if ($res) {
            $context->set('session', $session);
        }

        yield null;
    }
}