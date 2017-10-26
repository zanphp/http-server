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

class MiddlewareCustomTest extends TaskTestCase {

    public function taskCustomFilter(){
        $params = [
            'test' => '',
        ];
        $httpClient = new HttpClient(SERVER_HOST, SERVER_PORT);
        try {
            $response = (yield $httpClient->get('/index/customFilter', $params));
        } catch (\Exception $e) {
            $this->assertInstanceOf(HttpClientTimeoutException::class, $e, $e->getMessage());
            return;
        }
        $result = $response->getBody();
        $this->assertEquals($result, http_build_query(array('test' => 'TestCustomFilter')), "CustomFilter failed");
    }

    public function taskCustomExceptionHandle(){
        $params = [
            'test' => '',
        ];
        $httpClient = new HttpClient(SERVER_HOST, SERVER_PORT);
        try {
            $response = (yield $httpClient->get('/index/exception', $params));
        } catch (\Exception $e) {
            $this->assertInstanceOf(HttpClientTimeoutException::class, $e, $e->getMessage());
            return;
        }
        $result = $response->getBody();
        $this->assertEquals($result, "CustomExceptionHandler is working", "CustomExceptionHandle failed");
    }

}
