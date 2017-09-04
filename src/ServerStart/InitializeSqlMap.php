<?php

namespace ZanPHP\HttpServer\ServerStart;

use ZanPHP\Contracts\Foundation\Bootable;
use ZanPHP\Database\Sql\SqlMapInitiator;

class InitializeSqlMap implements Bootable
{

    public function bootstrap($server)
    {
        SqlMapInitiator::getInstance()->init();
    }
}