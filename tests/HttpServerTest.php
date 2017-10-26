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

class HttpServerTest extends TaskTestCase {

    public function taskHttpServerWork(){
        $params = [
            'txt' => 'aaa',
            'size' => 200,
            'margin' => 20,
            'level' => 0,
            'hint' => 2,
            'case' => 1,
            'ver' => 1,
        ];
        $httpClient = new HttpClient(SERVER_HOST, SERVER_PORT);
        try {
            $response = (yield $httpClient->get('/index/index', $params));
        } catch (\Exception $e) {
            $this->assertInstanceOf(HttpClientTimeoutException::class, $e, $e->getMessage());
            return;
        }
        $result = $response->getBody();
        $this->assertEquals($result, http_build_query($params), "get http server request failed");
    }

}
