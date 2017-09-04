<?php

namespace Zan\Framework\Network\Http;

use swoole_http_response as SwooleHttpResponse;
use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;

class RequestTask
{
    private $RequestTask;

    public function __construct(Request $request, SwooleHttpResponse $swooleResponse, Context $context, MiddlewareManager $middlewareManager)
    {
        $this->RequestTask = new \ZanPHP\HttpServer\RequestTask();
    }

    public function run()
    {
        $this->RequestTask->run();
    }

    public function doRun()
    {
        $this->RequestTask->doRun();
    }
}
