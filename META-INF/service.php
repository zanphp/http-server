<?php

use ZanPHP\Support\Di;

$container = \ZanPHP\Container\Container::getInstance();

$container->bind("ServerBase.HttpServer", function ($_, $args) {
    return Di::make(\ZanPHP\HttpServer\Server::class, [$args[0], $args[1]]);
});

return [];