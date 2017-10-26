<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/18
 * Time: 上午11:43
 */
namespace ZanPHP\HttpServer\Tests;

use ZanPHP\Config\ConfigLoader;
use ZanPHP\ServerBase\Middleware\MiddlewareConfig;
use ZanPHP\Contracts\Network\Request;

class RequestTest implements Request {

    private $route;

    public function __construct($route){
        $this->route = $route;
    }

    public function getRoute(){
        return $this->route;
    }
}

class MiddlewareConfigTest extends UnitTestCase {

    public function testMiddlewareGroup(){
        $middlewareConfig = ConfigLoader::getInstance()->load(__DIR__ . '/resource/middleware/');
        $middlewareConfig = isset($middlewareConfig['middleware']) ? $middlewareConfig['middleware'] : [];
        MiddlewareConfig::getInstance()->setConfig($middlewareConfig);

        $request = new RequestTest('/trade/test');
        $group = MiddlewareConfig::getInstance()->getRequestFilters($request);

        $this->assertContains( 'Acl', $group, 'MiddlewareManager::getGroupValue fail');
        $this->assertNotContains( 'Trade', $group, 'MiddlewareManager::getGroupValue fail');


        $request = new RequestTest('/trade/order/test?asdb=sad');
        $group = MiddlewareConfig::getInstance()->getRequestFilters($request);

        $this->assertContains( 'Acl', $group, 'MiddlewareManager::getGroupValue fail');
        $this->assertContains( 'Trade', $group, 'MiddlewareManager::getGroupValue fail');

    }

}
