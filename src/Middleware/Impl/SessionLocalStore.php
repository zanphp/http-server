<?php

namespace ZanPHP\HttpServer\Middleware\Impl;

use ZanPHP\Cache\APCuStore;
use ZanPHP\Config\Repository;
use ZanPHP\Contracts\Session\Storable;

class SessionLocalStore implements Storable
{
    const StorePrefix = "sid_";
    const SidLen = 32;
    const SidBitsPerCharacter = 5;

    private $store;
    private $ttl;
    private $prefix;
    private $sidBitsPerCharacter;

    public function __construct()
    {
        $this->store = new APCuStore(self::StorePrefix);
        $repository = make(Repository::class);
        $this->ttl = $repository->get("server.session.ttl", 0);
        $this->prefix = $repository->get("server.session.prefix", "zanphp");
        $this->sidBitsPerCharacter = $repository->get("server.session.sid_bits_per_character", self::SidBitsPerCharacter);
    }

    public function generateId()
    {
        if (function_exists("session_create_id")) {
            return session_create_id($this->prefix);
        } else {
            return $this->prefix . $this->sessionCreateId();
        }
    }

    public function get($sid)
    {
        $raw = $this->store->get($sid);
        if ($raw) {
            return json_decode($raw, true)?: [];
        }
        return [];
    }

    public function set($sid, array $value)
    {
        $value = json_encode($value);
        $this->store->put($sid, $value, $this->ttl);
        return true;
    }

    public function del($sid)
    {
        return $this->store->forget($sid);
    }

    /**
     * static size_t bin_to_readable(unsigned char *in, size_t inlen, char *out, char nbits)
     * @param string $bytes
     * @param int $nbits 用来控制随机字符范围, 4~6, 4:0~w ...
     * @return string
     */
    private function bin2readable($bytes, $nbits)
    {
        static $hexconvtab = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,-"; // 64
        $nbits = min(6, max(4, $nbits));

        $inlen = strlen($bytes);

        $out = "";
        $w = 0;
        $have = 0;
        $mask = (1 << $nbits) - 1;
        $i = 0;

        while ($inlen--) {
            if ($have < $nbits) {
                if ($i < $inlen) {
                    $w |= ord($bytes[$i++]) << $have;
                    $have += 8;
                } else {
                    /* consumed everything? */
                    if ($have == 0) break;
                    /* No? We need a final round */
                    $have = $nbits;
                }
            }

            /* consume nbits */
            $out .= $hexconvtab[$w & $mask];
            $w >>= $nbits;
            $have -= $nbits;
        }

        return $out;
    }

    // PHPAPI zend_string *php_session_create_id(PS_CREATE_SID_ARGS)
    private function sessionCreateId()
    {
        switch ($this->sidBitsPerCharacter) {
            case 4:
                $len = 48;
                break;
            case 5:
                $len = 52;
                break;
            case 6:
            default:
                $len = 56;

        }
        $bytes = random_bytes($len);
        return $this->bin2readable($bytes, self::SidBitsPerCharacter);
    }
}