<?php

namespace Zan\Framework\Network\Http\Middleware;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestFilter;

class SessionFilter implements RequestFilter
{
    private $SessionFilter;

    public function __construct()
    {
        $this->SessionFilter = new \ZanPHP\HttpServer\Middleware\SessionFilter();
    }

    public function doFilter(Request $request, Context $context)
    {
        $this->SessionFilter->doFilter($request, $context);
    }
}