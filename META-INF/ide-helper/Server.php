<?php

namespace Zan\Framework\Network\Http;

use swoole_http_request as SwooleHttpRequest;
use swoole_http_response as SwooleHttpResponse;
use ZanPHP\ServerBase\ServerBase;


class Server extends ServerBase
{
    public function setSwooleEvent()
    {
        \ZanPHP\HttpServer\Server::setSwooleEvent();
    }

    protected function init()
    {
        \ZanPHP\HttpServer\Server::init();
    }

    public function onStart($swooleServer)
    {
        \ZanPHP\HttpServer\Server::onStart($swooleServer);
    }

    public function onShutdown($swooleServer)
    {
        \ZanPHP\HttpServer\Server::onShutdown($swooleServer);
    }

    public function onWorkerStart($swooleServer, $workerId)
    {
        \ZanPHP\HttpServer\Server::onWorkerStart($swooleServer, $workerId);
    }

    public function onWorkerStop($swooleServer, $workerId)
    {
        \ZanPHP\HttpServer\Server::onWorkerStop($swooleServer, $workerId);
    }

    public function onWorkerError($swooleServer, $workerId, $workerPid, $exitCode, $sigNo)
    {
        \ZanPHP\HttpServer\Server::onWorkerError($swooleServer, $workerId, $workerPid, $exitCode, $sigNo);
    }

    public function onRequest(SwooleHttpRequest $httpRequest, SwooleHttpResponse $httpResponse)
    {
        \ZanPHP\HttpServer\Server::onRequest($httpRequest, $httpResponse);
    }
}
