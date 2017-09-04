<?php


namespace Zan\Framework\Network\Http\Security\Csrf;

class CsrfTokenManager implements CsrfTokenManagerInterface
{
    public function createToken()
    {
       \ZanPHP\HttpServer\Security\Csrf\CsrfTokenManager::createToken();
    }

    public function refreshToken(CsrfToken $token)
    {
        \ZanPHP\HttpServer\Security\Csrf\CsrfTokenManager::refreshToken($token);
    }

    public function parseToken($tokenRaw)
    {
        \ZanPHP\HttpServer\Security\Csrf\CsrfTokenManager::parseToken($tokenRaw);
    }

    public function isTokenValid(array $modules, CsrfToken $token = null)
    {
        \ZanPHP\HttpServer\Security\Csrf\CsrfTokenManager::isTokenValid($modules, $token);
    }

    public function getTTL(array $modules)
    {
        \ZanPHP\HttpServer\Security\Csrf\CsrfTokenManager::getTTL($modules);
    }
}