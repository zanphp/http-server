<?php

namespace Zan\Framework\Network\Http\ServerStart;

class InitializeMiddleware
{
    public function bootstrap($server)
    {
        \ZanPHP\HttpServer\ServerStart\InitializeMiddleware::bootstrap($server);
    }
}
