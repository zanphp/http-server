<?php
namespace Zan\Framework\Network\Http\ServerStart;

class InitializeProxyIps
{
    public function bootstrap($server)
    {
       \ZanPHP\HttpServer\ServerStart\InitializeProxyIps::bootstrap($server);
    }
}
