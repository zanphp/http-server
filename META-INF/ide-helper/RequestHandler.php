<?php

namespace Zan\Framework\Network\Http;

use swoole_http_request as SwooleHttpRequest;
use swoole_http_response as SwooleHttpResponse;

class RequestHandler
{
    private $RequestHandler;

    public function __construct()
    {
        $this->RequestHandler = new \ZanPHP\HttpServer\RequestHandler();
    }

    public function handle(SwooleHttpRequest $swooleRequest, SwooleHttpResponse $swooleResponse)
    {
        $this->RequestHandler->handle($swooleRequest,$swooleResponse);
    }

    public function handleRequestFinish()
    {
        $this->RequestHandler->handleRequestFinish();
    }

    public function handleTimeout()
    {
        $this->RequestHandler->handleTimeout();
    }
}
