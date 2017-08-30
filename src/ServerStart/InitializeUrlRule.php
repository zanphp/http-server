<?php

namespace ZanPHP\HttpServer\ServerStart;

use ZanPHP\Routing\UrlRuleInitiator;

class InitializeUrlRule
{
    /**
     * @param $server
     */
    public function bootstrap($server)
    {
        UrlRuleInitiator::getInstance()->init();
    }
} 