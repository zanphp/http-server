<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/30
 * Time: 下午3:36
 */
return [
    'common'           => [
        'connection'    => 'redis.default_write',
    ],
    'test' => [
        'key' => 'session_%s'
    ],
];