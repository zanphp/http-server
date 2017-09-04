<?php

namespace Zan\Framework\Network\Http;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;

class Dispatcher
{
    private $Dispatcher;

    public function __construct()
    {
        $this->Dispatcher = new \ZanPHP\HttpServer\Dispatcher();
    }

    public function dispatch(Request $request, Context $context)
    {
        $this->Dispatcher->dispatch($request,$context);
    }
}
