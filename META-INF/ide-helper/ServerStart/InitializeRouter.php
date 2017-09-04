<?php

namespace Zan\Framework\Network\Http\ServerStart;

class InitializeRouter
{
    private $InitializeRouter;

    public function __construct()
    {
        $this->InitializeRouter = new \ZanPHP\HttpServer\ServerStart\InitializeRouter();
    }

    public function bootstrap($server)
    {
        $this->InitializeRouter->bootstrap($server);
    }
}