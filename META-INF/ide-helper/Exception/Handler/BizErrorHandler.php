<?php

namespace Zan\Framework\Network\Http\Exception\Handler;

use ZanPHP\Contracts\Foundation\ExceptionHandler;

class BizErrorHandler implements ExceptionHandler
{
    public function handle(\Exception $e)
    {
        \ZanPHP\HttpServer\Exception\Handler\BizErrorHandler::handle($e);
    }
}
