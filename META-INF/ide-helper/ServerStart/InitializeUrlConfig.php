<?php

namespace Zan\Framework\Network\Http\ServerStart;


class InitializeUrlConfig
{
    private $InitializeUrlConfig;

    public function __construct()
    {
        $this->InitializeUrlConfig = new \ZanPHP\HttpServer\ServerStart\InitializeUrlConfig();
    }

    public function bootstrap($server)
    {
        $this->InitializeUrlConfig->bootstrap($server);
    }
}