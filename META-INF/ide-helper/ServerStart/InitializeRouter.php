<?php

namespace Zan\Framework\Network\Http\ServerStart;

class InitializeRouter
{
    public function bootstrap($server)
    {
        \ZanPHP\HttpServer\ServerStart\InitializeRouter::bootstrap($server);
    }
}