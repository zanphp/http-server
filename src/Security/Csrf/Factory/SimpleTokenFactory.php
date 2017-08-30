<?php


namespace ZanPHP\HttpServer\Security\Csrf\Factory;

use ZanPHP\Contracts\Config\Repository;
use ZanPHP\HttpServer\Security\Csrf\CsrfToken;
use ZanPHP\Utilities\Encrpt\SimpleEncrypt;

class SimpleTokenFactory implements TokenFactoryInterface
{

    private $key;

    public function __construct()
    {
        $repository = make(Repository::class);
        $this->key = $repository->get('csrf._default.key', NULL);
    }

    public function buildToken($id, $tokenTime)
    {
        $raw = SimpleEncrypt::encrypt($id . ',' . $tokenTime, $this->key);
        return new CsrfToken($id, $tokenTime, $raw);
    }

    public function buildFromRawText($tokenRaw)
    {
        $raw = SimpleEncrypt::decrypt($tokenRaw, $this->key);
        if (!$raw) {
            return null;
        }
        list($id, $tokenTime) = explode(',', $raw);
        return new CsrfToken($id, $tokenTime, $tokenRaw);
    }
}