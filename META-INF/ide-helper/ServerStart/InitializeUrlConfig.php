<?php

namespace Zan\Framework\Network\Http\ServerStart;


class InitializeUrlConfig
{
    public function bootstrap($server)
    {
        \ZanPHP\HttpServer\ServerStart\InitializeUrlConfig::bootstrap($server);
    }
}