<?php
use ZanPHP\HttpServer\Tests\Middleware\TestCustomExceptionHandler;

return [
    'group' => [
        'exception' =>[
            TestCustomExceptionHandler::class
        ],
    ],
    'match' => [
        ['index/exception', 'exception'],
    ],

];