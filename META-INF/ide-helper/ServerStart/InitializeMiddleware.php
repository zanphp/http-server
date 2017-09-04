<?php

namespace Zan\Framework\Network\Http\ServerStart;

class InitializeMiddleware
{
    private $InitializeMiddleware;

    public function __construct()
    {
        $this->InitializeMiddleware = new \ZanPHP\HttpServer\ServerStart\InitializeMiddleware();
    }

    public function bootstrap($server)
    {
        $this->InitializeMiddleware->bootstrap($server);
    }
}
