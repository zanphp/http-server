<?php

namespace Zan\Framework\Network\Http\Middleware;

class Session
{
    public function init()
    {
        \ZanPHP\HttpServer\Middleware\Session::init();
    }

    public function set($key, $value)
    {
        \ZanPHP\HttpServer\Middleware\Session::set($key, $value);
    }

    public function get($key)
    {
        \ZanPHP\HttpServer\Middleware\Session::get($key);
    }

    public function delete($key)
    {
        \ZanPHP\HttpServer\Middleware\Session::delete($key);
    }

    public function destroy()
    {
        \ZanPHP\HttpServer\Middleware\Session::destroy();
    }

    public function getSessionId()
    {
        \ZanPHP\HttpServer\Middleware\Session::getSessionId();
    }

    public function writeBack() {
        \ZanPHP\HttpServer\Middleware\Session::writeBack();
    }

    public static function sessionEncode( array $data ) {
        \ZanPHP\HttpServer\Middleware\Session::sessionEncode($data);
    }
}