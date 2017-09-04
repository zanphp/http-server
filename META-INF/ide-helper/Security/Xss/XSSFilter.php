<?php


namespace Zan\Framework\Network\Http\Security\Xss;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestFilter;

class XSSFilter Implements RequestFilter
{

    public function doFilter(Request $request, Context $context)
    {
        \ZanPHP\HttpServer\Security\Xss\XSSFilter::doFilter($request,$context);
    }

    protected function parseItem(array $input = null)
    {
        \ZanPHP\HttpServer\Security\Xss\XSSFilter::parseItem($input);
    }

    protected function cleanXSS($data)
    {
        \ZanPHP\HttpServer\Security\Xss\XSSFilter::cleanXSS($data);
    }
}