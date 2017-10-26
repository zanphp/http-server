<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/18
 * Time: 上午11:43
 */
return [
    'default_write' => [
        'engine'=> 'redis',
        'host' => REDIS_HOST,
        'port' => REDIS_PORT,
        'pool'  => [
            'maximum-connection-count' => 10,
            'minimum-connection-count' => 1,
            'keeping-sleep-time' => 10,
            'init-connection'=> 1,
        ],
    ]
];
