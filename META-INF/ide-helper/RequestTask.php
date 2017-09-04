<?php

namespace Zan\Framework\Network\Http;

class RequestTask
{
    public function run()
    {
        \ZanPHP\HttpServer\RequestTask::run();
    }

    public function doRun()
    {
        \ZanPHP\HttpServer\RequestTask::doRun();
    }
}
