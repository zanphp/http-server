<?php
require __DIR__ . '/autoload_test.php';
use Zan\Framework\Foundation\Application;
use swoole_http_server as SwooleHttpServer;
//use swoole_server as SwooleTcpServer;
//use swoole_websocket_server as SwooleWebSocketServer;
use ZanPHP\Contracts\Config\Repository;
use ZanPHP\HttpServer\Server;
use ZanPHP\Support\Di;

$appName = 'http-server-test';
$rootPath = realpath(__DIR__);

$app = new Application($appName, $rootPath);
$repository = make(Repository::class);
$config = $repository->get('server');
if (empty($config)) {
    throw new RuntimeException('server config not found');
}
if (empty($config['host']) || empty($config['port'])) {
    throw new RuntimeException('server config error: empty ip/port');
}
$serverConfig = $config['config'];
$serverConfig['max_request'] = 0;

$swooleServer = Di::make(SwooleHttpServer::class, [$config['host'], $config['port']], true);
$httpserver = Di::make(Server::class, [$swooleServer, $serverConfig]);

$httpserver->start();

//return $app;

