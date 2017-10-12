<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/29
 * Time: 上午11:18
 */

namespace ZanPHP\HttpServer\Tests\Middleware;

use ZanPHP\Contracts\Foundation\ExceptionHandler;
use ZanPHP\HttpFoundation\Response\Response;

class TestCustomExceptionHandler implements ExceptionHandler
{
    public function handle(\Exception $e)
    {
        return new Response("CustomExceptionHandler is working");
    }
}