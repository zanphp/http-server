<?php

namespace ZanPHP\HttpServer\ServerStart;

use Zan\Framework\Contract\Network\Bootable;
use ZanPHP\Database\Sql\SqlMapInitiator;

class InitializeSqlMap implements Bootable
{

    public function bootstrap($server)
    {
        SqlMapInitiator::getInstance()->init();
    }
}