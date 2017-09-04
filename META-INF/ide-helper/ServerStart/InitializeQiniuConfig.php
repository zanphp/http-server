<?php

namespace Zan\Framework\Network\Http\ServerStart;

class InitializeQiniuConfig
{
    public function bootstrap($server)
    {
        \ZanPHP\HttpServer\ServerStart\InitializeQiniuConfig::bootstrap($server);
    }
}