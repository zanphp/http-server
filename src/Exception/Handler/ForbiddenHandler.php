<?php

namespace ZanPHP\HttpServer\Exception\Handler;

use ZanPHP\Contracts\Foundation\ExceptionHandler;
use ZanPHP\HttpFoundation\Response\JsonResponse;
use ZanPHP\HttpFoundation\Response\Response;
use ZanPHP\HttpServer\Security\Csrf\Exception\TokenException;

class ForbiddenHandler implements ExceptionHandler
{

    /**
     * @param \Exception $e
     *  * \Thrift\Exception\TException
     *  * \Zan\Framework\Foundation\Exception\ZanException
     *      * \Zan\Framework\Foundation\Exception\SystemException
     *      * \Zan\Framework\Foundation\Exception\BusinessException
     *      * OtherZanExceptions
     *  * OtherExceptions
     *
     * @return mixed
     *  * bool
     */
    public function handle(\Exception $e)
    {
        if ($e instanceof TokenException) {
            $errMsg = '禁止访问';
            $errorPagePath = getenv("path.root") . '/vendor/zanphp/http-view/src/Pages/Error.php';
            $errorPage = require $errorPagePath;

            $request = (yield getContext('request'));
            if ($request->wantsJson()) {
                $context = [
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
                    'data' => '',
                ];
                yield new JsonResponse($context);
            } else {
                //html
                yield new Response($errorPage, Response::HTTP_FORBIDDEN);
            }
        }
    }
}