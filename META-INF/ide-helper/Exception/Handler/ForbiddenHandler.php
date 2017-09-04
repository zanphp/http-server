<?php


namespace Zan\Framework\Network\Http\Exception\Handler;

use ZanPHP\Contracts\Foundation\ExceptionHandler;

class ForbiddenHandler implements ExceptionHandler
{
    private $ForbiddenHandler;

    public function __construct()
    {
        $this->ForbiddenHandler = new \ZanPHP\HttpServer\Exception\Handler\ForbiddenHandler();
    }

    public function handle(\Exception $e)
    {
        $this->ForbiddenHandler->handle($e);
    }
}