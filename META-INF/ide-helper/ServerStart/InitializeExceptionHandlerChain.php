<?php

namespace Zan\Framework\Network\Http\ServerStart;


class InitializeExceptionHandlerChain
{
    /**
     * @param \Zan\Framework\Network\Http\Server $server
     */
    public function bootstrap($server)
    {
        \ZanPHP\HttpServer\ServerStart\InitializeExceptionHandlerChain::bootstrap($server);
    }
}
