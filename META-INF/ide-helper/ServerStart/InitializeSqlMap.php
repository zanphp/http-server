<?php


namespace Zan\Framework\Network\Http\ServerStart;

use ZanPHP\Contracts\Foundation\Bootable;

class InitializeSqlMap implements Bootable
{
    public function bootstrap($server)
    {
        \ZanPHP\HttpServer\ServerStart\InitializeSqlMap::bootstrap($server);
    }
}