<?php

namespace Zan\Framework\Network\Http\Exception\Handler;

use ZanPHP\Contracts\Foundation\ExceptionHandler;

class BizErrorHandler implements ExceptionHandler
{
    private $BizErrorHandler;

    public function __construct()
    {
        $this->BizErrorHandler = new \ZanPHP\HttpServer\Exception\Handler\BizErrorHandler();
    }

    public function handle(\Exception $e)
    {
        $this->BizErrorHandler->handle($e);
    }
}
