<?php


namespace Zan\Framework\Network\Http\Security\Csrf;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestFilter;


class CsrfFilter Implements RequestFilter
{
    private $CsrfFilter;

    public function __construct()
    {
        $this->CsrfFilter = new \ZanPHP\HttpServer\Security\Csrf\CsrfFilter();
    }

    public function doFilter(Request $request, Context $context)
    {
        $this->CsrfFilter->doFilter($request,$context);
    }
}