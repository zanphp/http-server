<?php

namespace ZanPHP\HttpServer\ServerStart;

use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Utilities\Types\URL;

class InitializeUrlConfig
{
    public function bootstrap($server)
    {
        $repository = make(Repository::class);
        $config = $repository->get('url', []);
        URL::setConfig($config);
    }
}