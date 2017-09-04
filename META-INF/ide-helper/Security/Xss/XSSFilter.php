<?php


namespace Zan\Framework\Network\Http\Security\Xss;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestFilter;

class XSSFilter Implements RequestFilter
{
    private $XSSFilter;

    public function __construct()
    {
        $this->XSSFilter = new \ZanPHP\HttpServer\Security\Xss\XSSFilter();
    }

    public function doFilter(Request $request, Context $context)
    {
        $this->XSSFilter->doFilter($request,$context);
    }

    protected function parseItem(array $input = null)
    {
        $this->XSSFilter->parseItem($input);
    }

    protected function cleanXSS($data)
    {
        $this->XSSFilter->cleanXSS($data);
    }
}