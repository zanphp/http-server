<?php


namespace Zan\Framework\Network\Http\Security\Csrf;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestFilter;


class CsrfFilter Implements RequestFilter
{
    public function doFilter(Request $request, Context $context)
    {
        \ZanPHP\HttpServer\Security\Csrf\CsrfFilter::doFilter($request,$context);
    }
}