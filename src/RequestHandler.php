<?php

namespace ZanPHP\HttpServer;

use swoole_http_request as SwooleHttpRequest;
use swoole_http_response as SwooleHttpResponse;
use ZanPHP\ServerBase\Middleware\MiddlewareManager;
use ZanPHP\WorkerMonitor\WorkerMonitor;
use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Coroutine\Context;
use ZanPHP\Coroutine\Event;
use ZanPHP\Coroutine\Signal;
use ZanPHP\Coroutine\Task;
use ZanPHP\Exception\Network\ExcessConcurrencyException;
use ZanPHP\HttpFoundation\Cookie as CookieAlias;
use ZanPHP\HttpFoundation\Request\Request;
use ZanPHP\HttpFoundation\Response\BaseResponse;
use ZanPHP\HttpFoundation\Response\InternalErrorResponse;
use ZanPHP\HttpFoundation\Response\JsonResponse;
use ZanPHP\HttpFoundation\Response\Response;
use ZanPHP\Routing\Router;
use ZanPHP\Support\Time;
use ZanPHP\Timer\Timer;

class RequestHandler
{
    /** @var null|Context  */
    private $context = null;

    /** @var MiddlewareManager */
    private $middleWareManager = null;

    /** @var Task */
    private $task = null;

    /** @var Event */
    private $event = null;

    /** @var Request */
    private $request = null;

    const DEFAULT_TIMEOUT = 30 * 1000;

    public function __construct()
    {
        $this->context = new Context();
        $this->event = $this->context->getEvent();
    }

    public function handle(SwooleHttpRequest $swooleRequest, SwooleHttpResponse $swooleResponse)
    {
        try {
            $request = Request::createFromSwooleHttpRequest($swooleRequest);

            if (false === $this->initContext($request, $swooleRequest, $swooleResponse)) {
                //filter ico file access
                return;
            }
            $this->middleWareManager = new MiddlewareManager($request, $this->context);

            $isAccept = WorkerMonitor::instance()->reactionReceive();
            //限流
            if (!$isAccept) {
                throw new ExcessConcurrencyException('现在访问的人太多,请稍后再试..', 503);
            }

            //bind event
            $timeout = $this->context->get('request_timeout');
            $this->event->once($this->getRequestFinishJobId(), [$this, 'handleRequestFinish']);
            Timer::after($timeout, [$this, 'handleTimeout'], $this->getRequestTimeoutJobId());

            $requestTask = new RequestTask($request, $swooleResponse, $this->context, $this->middleWareManager);
            $coroutine = $requestTask->run();
            $this->task = new Task($coroutine, $this->context);
            $this->task->run();
            clear_ob();
            return;
        } catch (\Throwable $t) {
            $e = t2ex($t);
        } catch (\Exception $e) {

        }

        clear_ob();

        $repository = make(Repository::class);
        $debug = $repository->get("debug");
        if ($debug) {
            /** @noinspection PhpUndefinedVariableInspection */
            echo_exception($e);
        }
        if ($this->middleWareManager) {
            $coroutine = $this->middleWareManager->handleHttpException($e);
        } else {
            $coroutine = RequestExceptionHandlerChain::getInstance()->handle($e);
        }
        Task::execute($coroutine, $this->context);
        $this->event->fire($this->getRequestFinishJobId());
    }

    private function initContext(Request $request, SwooleHttpRequest $swooleRequest, SwooleHttpResponse $swooleResponse)
    {
        $this->request = $request;
        $this->context->set('swoole_request', $swooleRequest);
        $this->context->set('request', $request);
        $this->context->set('swoole_response', $swooleResponse);

        $router = Router::getInstance();
        $route = $router->route($request);
        if ($route === false)
            return false;
        $this->context->set('controller_name', $route['controller_name']);
        $this->context->set('action_name', $route['action_name']);
        $this->context->set('action_args', $route['action_args']);

        $cookie = new CookieAlias($request, $swooleResponse);
        $this->context->set('cookie', $cookie);

        $this->context->set('request_time', Time::stamp());
        $repository = make(Repository::class);
        $request_timeout = $repository->get('server.request_timeout');
        $request_timeout = $request_timeout ? $request_timeout : self::DEFAULT_TIMEOUT;
        $this->context->set('request_timeout', $request_timeout);

        $this->context->set('request_end_event_name', $this->getRequestFinishJobId());
    }

    public function handleRequestFinish()
    {
        Timer::clearAfterJob($this->getRequestTimeoutJobId());
        $response = $this->context->get('response');
        if ($response === null) {
            //伪造响应,避免terminate接口传入null导致fatal error
            $response = new Response();
        }
        $coroutine = $this->middleWareManager->executeTerminators($response);
        Task::execute($coroutine, $this->context);
    }

    public function handleTimeout()
    {
        try {
            $this->task->setStatus(Signal::TASK_KILLED);
            $this->logTimeout();

            $request = $this->context->get('request');
            if ($request && $request->wantsJson()) {
                $data = [
                    'code' => 10000,
                    'msg' => '网络超时',
                    'data' => '',
                ];
                $response = new JsonResponse($data, BaseResponse::HTTP_GATEWAY_TIMEOUT);
            } else {
                $response = new InternalErrorResponse('服务器超时', BaseResponse::HTTP_GATEWAY_TIMEOUT);
            }

            $this->context->set('response', $response);
            $swooleResponse = $this->context->get('swoole_response');
            $response->sendBy($swooleResponse);
            $this->event->fire($this->getRequestFinishJobId());
        } catch (\Throwable $t) {
            echo_exception($t);
        } catch (\Exception $ex) {
            echo_exception($ex);
        }
    }

    private function logTimeout()
    {
        // 注意: 此处需要配置 server.proxy
        $remoteIp = $this->request->getClientIp();
        $route = $this->request->getRoute();
        $query = http_build_query($this->request->query->all());
        sys_error("SERVER TIMEOUT [remoteIP=$remoteIp, url=$route?$query]");
    }

    private function getRequestFinishJobId()
    {
        return spl_object_hash($this) . '_request_finish';
    }

    private function getRequestTimeoutJobId()
    {
        return spl_object_hash($this) . '_handle_timeout';
    }
}
