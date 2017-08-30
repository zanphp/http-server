<?php

namespace ZanPHP\HttpServer\ServerStart;

use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Routing\RouteInitiator;

class InitializeRouter
{
    /**
     * @param $server
     */
    public function bootstrap($server)
    {
        $repository = make(Repository::class);
        RouteInitiator::getInstance()->init($repository->get('route'));
    }
}