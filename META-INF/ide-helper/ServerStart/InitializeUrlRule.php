<?php

namespace Zan\Framework\Network\Http\ServerStart;


class InitializeUrlRule
{
    public function bootstrap($server)
    {
        \ZanPHP\HttpServer\ServerStart\InitializeUrlRule::bootstrap($server);
    }
} 