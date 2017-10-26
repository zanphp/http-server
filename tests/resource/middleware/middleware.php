<?php

use ZanPHP\HttpServer\Tests\Middleware\TestCustomFilter;

return [
    'group'     => [
        'web'   => [
            'Acl','Auth'
        ],
        'trade' =>[
            'Acl','Auth','Trade'
        ],
        'filter' =>[
            TestCustomFilter::class
        ],
    ],
    'match'     => [
        //The sequence is important, generic match is behind specific match
        ['trade/order/.*',  'trade'],
        ['trade/.*',  'web'],
        ['index/customFilter', 'filter'],
    ],
];
