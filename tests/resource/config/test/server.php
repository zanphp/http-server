<?php
return [
    'host'          => SERVER_HOST,
    'port'          => SERVER_PORT,
    'config' => [
        'worker_num'    => 1,
        'dispatch_mode' => 3,
        'max_request' => 100000,
        'reactor_num' => 1,
        'open_length_check' => 1,
        'package_length_type' => 'N',
        'package_length_offset' => 0,
        'package_body_offset' => 0,
        'open_nova_protocol' => 1,
        'package_max_length' => 200000
    ],
    'monitor' =>[
        'max_request'   => 100000,          //
        'max_live_time' => 1800000,         //30m
        'check_interval'=> 10000,           //1s
        'memory_limit'  => 1.5 * 1024 * 1024 * 1024,       //1.50G
        'cpu_limit'     => 70,
        'debug'         => false
    ],
    'request_timeout' => 30000,
    'session' => [
        'run' => true,
        'store_key' => 'test.test',
        'ttl' => 3600 * 24
    ],
];