<?php

namespace Zan\Framework\Network\Http\Security\Csrf\Factory;

class SimpleTokenFactory implements TokenFactoryInterface
{
    public function buildToken($id, $tokenTime)
    {
        \ZanPHP\HttpServer\Security\Csrf\Factory\SimpleTokenFactory::buildToken($id, $tokenTime);
    }

    public function buildFromRawText($tokenRaw)
    {
        \ZanPHP\HttpServer\Security\Csrf\Factory\SimpleTokenFactory::buildFromRawText($tokenRaw);
    }
}