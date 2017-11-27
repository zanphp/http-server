<?php

namespace ZanPHP\HttpServer\Middleware\Impl;

use InvalidArgumentException;
use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Contracts\Session\Storable;
use ZanPHP\NoSql\Facade\Cache;
use ZanPHP\Utilities\Encrpt\Uuid;

class SessionCacheStore implements Storable
{
    const CONFIG_KEY = 'server.session';
    private $sessionTpl;

    public function __construct()
    {
        $repository = make(Repository::class);
        $config = $repository->get(self::CONFIG_KEY);
        $this->sessionTpl = $config['store_key'];
    }

    public function generateId()
    {
        yield Uuid::get();
    }

    public function get($key)
    {
        $session = (yield Cache::get($this->sessionTpl, [$key]));
        if ($session) {
           yield $this->sessionDecode($session);
           return;
        }
        yield [];
    }

    public function set($key, array $value)
    {
        yield Cache::set($this->sessionTpl, [$key], $this->sessionEncode($value));
    }

    public function del($key)
    {
        yield Cache::del($this->sessionTpl, [$key]);
    }

    private function sessionDecode($session)
    {
        $sessionTable = array();
        $offset = 0;
        while ($offset < strlen($session)) {
            if (!strstr(substr($session, $offset), "|")) {
                throw new InvalidArgumentException("Invalid data, remaining: " . substr($session, $offset));
            }
            $pos = strpos($session, "|", $offset);
            $num = $pos - $offset;
            $varname = substr($session, $offset, $num);
            $offset += $num + 1;
            $data = unserialize(substr($session, $offset));
            $sessionTable[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $sessionTable;
    }

    public function sessionEncode( array $data )
    {
        $ret = '';
        foreach ( $data as $key => $value ) {
            if ( strcmp( $key, intval( $key ) ) === 0 ) {
                throw new InvalidArgumentException( "Ignoring unsupported integer key \"$key\"" );
            }
            if ( strcspn( $key, '|!' ) !== strlen( $key ) ) {
                throw new InvalidArgumentException( "Serialization failed: Key with unsupported characters \"$key\"" );
            }
            $v = serialize( $value );
            if ( $v === null ) {
                return null;
            }
            $ret .= "$key|$v";
        }
        return $ret;
    }
}