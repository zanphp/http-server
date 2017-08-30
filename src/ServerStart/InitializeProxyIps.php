<?php

namespace ZanPHP\HttpServer\ServerStart;

use ZanPHP\Contracts\Config\Repository;
use ZanPHP\HttpFoundation\Request\BaseRequest;

class InitializeProxyIps
{
    /**
     * @param \Zan\Framework\Network\Http\Server $server
     */
    public function bootstrap($server)
    {
        $repository = make(Repository::class);
        $proxy = $repository->get("server.proxy");
        if (is_array($proxy)) {
            BaseRequest::setTrustedProxies($proxy);
        }
    }
}
