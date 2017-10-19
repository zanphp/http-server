<?php

namespace ZanPHP\HttpServer\Middleware;

use InvalidArgumentException;
use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Contracts\Session\Storable;
use ZanPHP\Exception\ZanException;
use ZanPHP\HttpClient\HttpClient;
use ZanPHP\HttpFoundation\Request\Request;
use ZanPHP\HttpServer\Middleware\Impl\SessionCacheStore;
use ZanPHP\NoSql\Facade\Cache;
use ZanPHP\Utilities\Encrpt\Uuid;

class Session
{
    const YZ_SESSION_KEY = 'KDTSESSIONID';
    const CONFIG_KEY = 'server.session';

    private $request;
    private $cookie;
    private $session_id;
    private $session_map = array();
    private $config;
    private $isChanged = false;
    /** @var Storable */
    private $sessionStore;

    public function __construct(Request $request, $cookie)
    {
        $repository = make(Repository::class);
        $this->config = $repository->get(self::CONFIG_KEY);

        $this->request = $request;
        $this->cookie = $cookie;
        $repository = make(Repository::class);
        $clazz = $repository->get("zan_session.store_class");
        if ($clazz === null) {
            $clazz = SessionCacheStore::class;
        }
        $this->sessionStore = new $clazz();
    }

    public function init()
    {
        if (!$this->config['run']) {
            yield false;
            return;
        }

        $session_id = $this->request->cookie(self::YZ_SESSION_KEY);
        if (isset($session_id) && !empty($session_id)) {
            $this->session_id = $session_id;
        } else {
            $this->session_id = (yield $this->sessionStore->generateId());
            $this->cookie->set(self::YZ_SESSION_KEY, $this->session_id);
            yield true;
            return;
        }

        $this->session_map = (yield $this->sessionStore->get($this->session_id));
        yield true;
    }

    public function set($key, $value)
    {
        $this->session_map[$key] = $value;
        $this->isChanged = true;
        yield true;
    }

    public function get($key)
    {
        yield isset($this->session_map[$key]) ? $this->session_map[$key] : null;
    }

    public function delete($key)
    {
        unset($this->session_map[$key]);
        $this->isChanged = true;
        yield true;
    }

    public function destroy()
    {
        $ret = (yield $this->sessionStore->del($this->session_id));
        if (!$ret) {
            yield false;
            return;
        }
        $this->cookie->set($this->session_id, null, time() - 3600);
        $this->isChanged = false;
        yield true;
    }

    public function getSessionId()
    {
        yield $this->session_id;
    }

    public function writeBack() {
        if ($this->isChanged) {
            yield $this->sessionStore->set($this->session_id, $this->session_map);
            yield Cache::set($this->config['store_key'], [$this->session_id], $this->sessionEncode($this->session_map));
        }
    }

    public static function sessionEncode( array $data ) {
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