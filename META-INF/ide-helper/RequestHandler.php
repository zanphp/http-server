<?php

namespace Zan\Framework\Network\Http;

use swoole_http_request as SwooleHttpRequest;
use swoole_http_response as SwooleHttpResponse;

class RequestHandler
{
    public function handle(SwooleHttpRequest $swooleRequest, SwooleHttpResponse $swooleResponse)
    {
        \ZanPHP\HttpServer\RequestHandler::handle($swooleRequest,$swooleResponse);
    }

    public function handleRequestFinish()
    {
        \ZanPHP\HttpServer\RequestHandler::handleRequestFinish();
    }

    public function handleTimeout()
    {
        \ZanPHP\HttpServer\RequestHandler::handleTimeout();
    }
}
