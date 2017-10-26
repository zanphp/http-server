<?php

namespace ZanPHP\HttpServer;

use swoole_http_request as SwooleHttpRequest;
use swoole_http_response as SwooleHttpResponse;
use ZanPHP\Contracts\Config\Repository;
use ZanPHP\HttpServer\ServerStart\InitializeExceptionHandlerChain;
use ZanPHP\HttpServer\ServerStart\InitializeMiddleware;
use ZanPHP\HttpServer\ServerStart\InitializeProxyIps;
use ZanPHP\HttpServer\ServerStart\InitializeQiniuConfig;
use ZanPHP\HttpServer\ServerStart\InitializeRouter;
use ZanPHP\HttpServer\ServerStart\InitializeSqlMap;
use ZanPHP\HttpServer\ServerStart\InitializeUrlConfig;
use ZanPHP\HttpServer\ServerStart\InitializeUrlRule;
use ZanPHP\ServerBase\ServerBase;
use ZanPHP\ServerBase\ServerStart\InitLogConfig;
use ZanPHP\ServerBase\WorkerStart\InitializeConnectionPool;
use ZanPHP\ServerBase\WorkerStart\InitializeErrorHandler;
use ZanPHP\ServerBase\WorkerStart\InitializeHawkMonitor;
use ZanPHP\ServerBase\WorkerStart\InitializeServerDiscovery;
use ZanPHP\ServerBase\WorkerStart\InitializeServiceChain;
use ZanPHP\ServerBase\WorkerStart\InitializeWorkerMonitor;
use ZanPHP\ServiceStore\ServiceStore;
use ZanPHP\WorkerMonitor\WorkerMonitor;

class Server extends ServerBase
{
    protected $serverStartItems = [
        InitializeRouter::class,
        InitializeUrlRule::class,
        InitializeUrlConfig::class,
        InitializeQiniuConfig::class,
        InitializeMiddleware::class,
        InitializeExceptionHandlerChain::class,
        InitLogConfig::class,
        InitializeSqlMap::class,
        InitializeProxyIps::class,
    ];

    protected $workerStartItems = [
        InitializeErrorHandler::class,
        InitializeWorkerMonitor::class,
        InitializeHawkMonitor::class,
        InitializeConnectionPool::class,
        InitializeServerDiscovery::class,
        InitializeServiceChain::class,
    ];

    public function setSwooleEvent()
    {
        $this->swooleServer->on('start', [$this, 'onStart']);
        $this->swooleServer->on('shutdown', [$this, 'onShutdown']);

        $this->swooleServer->on('workerStart', [$this, 'onWorkerStart']);
        $this->swooleServer->on('workerStop', [$this, 'onWorkerStop']);
        $this->swooleServer->on('workerError', [$this, 'onWorkerError']);

        $this->swooleServer->on('request', [$this, 'onRequest']);
    }

    protected function init()
    {
        $repository = make(Repository::class);
        $config = $repository->get('registry');
        if (!isset($config['app_names']) || [] === $config['app_names']) {
            return;
        }
        ServiceStore::getInstance()->resetLockDiscovery();
    }

    public function onStart($swooleServer)
    {
        $this->writePid($swooleServer->master_pid);
        sys_echo("server starting .....[$swooleServer->host:$swooleServer->port]");
    }

    public function onShutdown($swooleServer)
    {
        $this->removePidFile();
        sys_echo("server shutdown .....");
    }

    public function onWorkerStart($swooleServer, $workerId)
    {
        $_SERVER["WORKER_ID"] = $workerId;
        $this->bootWorkerStartItem($workerId);
        sys_echo("worker *$workerId starting .....");
    }

    public function onWorkerStop($swooleServer, $workerId)
    {
        // ServerDiscoveryInitiator::getInstance()->unlockDiscovery($workerId);
        sys_echo("worker *$workerId stopping .....");

        $num = WorkerMonitor::getInstance()->reactionNum ?: 0;
        sys_echo("worker *$workerId still has $num requests in progress...");
    }

    public function onWorkerError($swooleServer, $workerId, $workerPid, $exitCode, $sigNo)
    {
        // ServerDiscoveryInitiator::getInstance()->unlockDiscovery($workerId);

        sys_echo("worker error happening [workerId=$workerId, workerPid=$workerPid, exitCode=$exitCode, signalNo=$sigNo]...");

        $num = WorkerMonitor::getInstance()->reactionNum ?: 0;
        sys_echo("worker *$workerId still has $num requests in progress...");
    }

    public function onRequest(SwooleHttpRequest $httpRequest, SwooleHttpResponse $httpResponse)
    {
        if ($this->__HB__($httpRequest, $httpResponse)) {
            return;
        }

        (new RequestHandler())->handle($httpRequest, $httpResponse);
    }

    private function __HB__(SwooleHttpRequest $httpRequest, SwooleHttpResponse $httpResponse)
    {
        if ($httpRequest->server["request_uri"] === "/_HB_.php") {
            $action = isset($httpRequest->get["service"]) ? $httpRequest->get["service"] : null;
            switch ($action) {
                case "online":
                    apcu_store("_HB_", true);
                    $httpResponse->status(200);
                    $httpResponse->end("online");
                    break;

                case "offline":
                    apcu_delete("_HB_");
                    $httpResponse->status(200);
                    $httpResponse->end("offline");
                    break;

                default:
                    if (apcu_exists("_HB_")) {
                        $httpResponse->status(200);
                        $httpResponse->end("online");
                    } else {
                        $httpResponse->status(404);
                        $httpResponse->end("offline");
                    }
                    break;
            }
            return true;
        }

        if (method_exists($this->swooleServer, "stats")) {
            if ($httpRequest->server["request_uri"] === "/eW91emFuCg==/stats") {
                $httpResponse->write(json_encode($this->swooleServer->stats()));
                return true;
            }
        }

        return false;
    }
}
