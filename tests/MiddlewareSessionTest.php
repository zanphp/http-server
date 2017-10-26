<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/18
 * Time: 上午11:43
 */
namespace ZanPHP\HttpServer\Tests;

use ZanPHP\HttpClient\HttpClient;
use ZanPHP\HttpClient\Exception\HttpClientTimeoutException;

class MiddlewareSessionTest extends TaskTestCase {

    public function taskSessionFilter(){
        $httpClient1 = new HttpClient(SERVER_HOST, SERVER_PORT);
        try {
            $response1 = (yield $httpClient1->get('/index/sessionFilter'));
        } catch (\Exception $e) {
            $this->assertInstanceOf(HttpClientTimeoutException::class, $e, $e->getMessage());
            return;
        }
        $cookies = explode('; ',$response1->getHeader('set-cookie'));
        $kdt_array = explode('=',$cookies[0]);
        $kdtsessionid = array_pop($kdt_array );

        $httpClient2 = new HttpClient(SERVER_HOST, SERVER_PORT);
        $httpClient2->setHeader(array('Cookie'=>'KDTSESSIONID='.$kdtsessionid));
        try {
            $response2 = (yield $httpClient2->get('/index/sessionFilter'));
        } catch (\Exception $e) {
            $this->assertInstanceOf(HttpClientTimeoutException::class, $e, $e->getMessage());
            return;
        }
        $value = json_decode($response2->getbody(),true);
        $this->assertTrue($value['exist'],'session set failed');
    }

}
