<?php
namespace Zan\Framework\Network\Http\ServerStart;

class InitializeProxyIps
{
    private $InitializeProxyIps;

    public function __construct()
    {
        $this->InitializeProxyIps = new \ZanPHP\HttpServer\ServerStart\InitializeProxyIps();
    }

    public function bootstrap($server)
    {
        $this->InitializeProxyIps->bootstrap($server);
    }
}
