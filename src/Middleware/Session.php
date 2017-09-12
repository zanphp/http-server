<?php

namespace ZanPHP\HttpServer\Middleware;

use InvalidArgumentException;
use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Exception\ZanException;
use ZanPHP\HttpClient\HttpClient;
use ZanPHP\HttpFoundation\Request\Request;
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
    private $session_changed_map = array();
    private $config;
    private $isChanged = false;

    public function __construct(Request $request, $cookie)
    {
        $repository = make(Repository::class);
        $this->config = $repository->get(self::CONFIG_KEY);

        $this->request = $request;
        $this->cookie = $cookie;

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
            $this->session_id = (yield $this->getUuid());
            $this->cookie->set(self::YZ_SESSION_KEY, $this->session_id);
            yield true;
            return;
        }

        $session = (yield Cache::get($this->config['store_key'], [$this->session_id]));
        if ($session) {
            $this->session_map = $this->sessionDecode($session);
        }
        yield true;
    }

    private function getUuid()
    {
        if (isset($this->config['enable_http']) && $this->config['enable_http'] === true) {
            $repository = make(Repository::class);
            $host = $repository->get("zan_session.host");
            $port = $repository->get("zan_session.port");
            $retries = 3;
            for ($i = 0; $i < $retries; $i++) {
                try {
                    $client = new HttpClient($host, $port);
                    $client->setHeader([
                        "Content-Type" => "application/json"
                    ]);
                    $response = (yield $client->post("/session/session/create", null, 300));
                    $response = json_decode($response->getBody(), true);
                    if (isset($response['data']['code']) && $response['data']['code'] === 200 &&
                        isset($response['data']['data']['sessionId'])) {
                        $uuid = $response['data']['data']['sessionId'];
                        break;
                    }
                } catch (\Throwable $t) {
                    echo_exception($t);
                    if ($i == $retries - 1) {
                        throw $t;
                    }
                } catch (\Exception $e) {
                    echo_exception($e);
                    if ($i == $retries - 1) {
                        throw $e;
                    }
                }
            }
        } else {
            $uuid = Uuid::get();
        }

        if (!isset($uuid)) {
            throw new ZanException("session get uuid failed");
        }
        yield $uuid;
    }

    public function set($key, $value)
    {
        $this->session_map[$key] = $value;
        $this->isChanged = true;
        $this->session_changed_map[] = ['key' => $key, 'value' => $value, 'opt' => 1];
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
        $this->session_changed_map[] = ['key' => $key, 'opt' => 0];
        yield true;
    }

    public function destroy()
    {
        $ret = (yield Cache::del($this->config['store_key'], [$this->session_id]));
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

    private function writeHttpInterface()
    {
        if (isset($this->config['enable_http']) && $this->config['enable_http'] === true) {
            if (isset($this->config['percent'])) {
                $percent = intval($this->config['percent']);
            } else {
                $percent = 0;
            }
            if (rand(1, 100) <= $percent) {
                $repository = make(Repository::class);
                $host = $repository->get("zan_session.host");
                $port = $repository->get("zan_session.port");
                $client = new HttpClient($host, $port);
                $client->setHeader([
                    "Content-Type" => "application/json"
                ]);
                $params = json_encode([
                    'data' => $this->session_changed_map,
                    'session_id' => $this->session_id
                ]);
                try {
                    yield $client->post("/session/session/setMultiUpdateObj", $params, 1000);
                } catch (\Throwable $t) {
                    echo_exception($t);
                } catch (\Exception $e) {
                    echo_exception($e);
                }
            }
        }
    }

    public function writeBack() {
        if ($this->isChanged) {
            yield $this->writeHttpInterface();
            yield Cache::set($this->config['store_key'], [$this->session_id], $this->sessionEncode($this->session_map));
        }
    }


    private static function sessionDecode($session) {
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