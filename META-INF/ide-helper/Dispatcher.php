<?php

namespace Zan\Framework\Network\Http;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;

class Dispatcher
{
    public function dispatch(Request $request, Context $context)
    {
        \ZanPHP\HttpServer\Dispatcher::dispatch($request,$context);
    }
}
