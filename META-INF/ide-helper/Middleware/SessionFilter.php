<?php

namespace Zan\Framework\Network\Http\Middleware;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestFilter;

class SessionFilter implements RequestFilter
{
    public function doFilter(Request $request, Context $context)
    {
        \ZanPHP\HttpServer\Middleware\SessionFilter::doFilter($request, $context);
    }
}