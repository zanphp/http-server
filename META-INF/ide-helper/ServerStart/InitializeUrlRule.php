<?php

namespace Zan\Framework\Network\Http\ServerStart;


class InitializeUrlRule
{
    private $InitializeUrlRule;

    public function __construct()
    {
        $this->InitializeUrlRule = new \ZanPHP\HttpServer\ServerStart\InitializeUrlRule();
    }

    public function bootstrap($server)
    {
        $this->InitializeUrlRule->bootstrap($server);
    }
} 