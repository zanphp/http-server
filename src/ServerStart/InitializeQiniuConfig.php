<?php

namespace ZanPHP\HttpServer\ServerStart;

use Zan\Framework\Sdk\Cdn\Qiniu;
use ZanPHP\Contracts\Config\Repository;

class InitializeQiniuConfig
{
    public function bootstrap($server)
    {
        $repository = make(Repository::class);
        $config = $repository->get('qiniu', []);
        if ($config) {
            Qiniu::setConfig($config);
        }
    }
}