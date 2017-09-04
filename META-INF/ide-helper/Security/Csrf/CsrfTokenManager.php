<?php

namespace Zan\Framework\Network\Http\Security\Csrf;

use ZanPHP\HttpServer\Security\Csrf\Factory\TokenFactoryInterface;

class CsrfTokenManager implements CsrfTokenManagerInterface
{
    private $CsrfTokenManager;

    public function __construct(TokenFactoryInterface $factory = null)
    {
        $this->CsrfTokenManager = new \ZanPHP\HttpServer\Security\Csrf\CsrfTokenManager($factory);
    }

    public function createToken()
    {
        $this->CsrfTokenManager->createToken();
    }

    public function refreshToken(CsrfToken $token)
    {
        $this->CsrfTokenManager->refreshToken($token);
    }

    public function parseToken($tokenRaw)
    {
        $this->CsrfTokenManager->parseToken($tokenRaw);
    }

    public function isTokenValid(array $modules, CsrfToken $token = null)
    {
        $this->CsrfTokenManager->isTokenValid($modules, $token);
    }

    public function getTTL(array $modules)
    {
        $this->CsrfTokenManager->getTTL($modules);
    }
}