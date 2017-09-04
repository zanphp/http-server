<?php


namespace Zan\Framework\Network\Http\ServerStart;

use ZanPHP\Contracts\Foundation\Bootable;

class InitializeSqlMap implements Bootable
{
    private $InitializeSqlMap;

    public function __construct()
    {
        $this->InitializeSqlMap = new \ZanPHP\HttpServer\ServerStart\InitializeSqlMap();
    }

    public function bootstrap($server)
    {
        $this->InitializeSqlMap->bootstrap($server);
    }
}