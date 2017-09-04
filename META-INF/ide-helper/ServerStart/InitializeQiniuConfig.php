<?php

namespace Zan\Framework\Network\Http\ServerStart;

class InitializeQiniuConfig
{
    private $InitializeQiniuConfig;

    public function __construct()
    {
        $this->InitializeQiniuConfig = new \ZanPHP\HttpServer\ServerStart\InitializeQiniuConfig();
    }

    public function bootstrap($server)
    {
        $this->InitializeQiniuConfig->bootstrap($server);
    }
}