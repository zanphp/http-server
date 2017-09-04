<?php

namespace Zan\Framework\Network\Http\Middleware;

use ZanPHP\HttpFoundation\Request\Request;

class Session
{
    private $Session;

    public function __construct(Request $request, $cookie)
    {
        $this->Session = new \ZanPHP\HttpServer\Middleware\Session($request, $cookie);
    }

    public function init()
    {
        $this->Session->init();
    }

    public function set($key, $value)
    {
        $this->Session->set($key, $value);
    }

    public function get($key)
    {
        $this->Session->get($key);
    }

    public function delete($key)
    {
        $this->Session->delete($key);
    }

    public function destroy()
    {
        $this->Session->destroy();
    }

    public function getSessionId()
    {
        $this->Session->getSessionId();
    }

    public function writeBack() {
        $this->Session->writeBack();
    }

    public static function sessionEncode( array $data ) {
        \ZanPHP\HttpServer\Middleware\Session::sessionEncode($data);
    }
}