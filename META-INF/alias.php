<?php


return [
    \ZanPHP\HttpServer\Exception\Handler\BizErrorHandler::class => \Zan\Framework\Network\Http\Exception\Handler\BizErrorHandler::class,
    \ZanPHP\HttpServer\Exception\Handler\ForbiddenHandler::class => \Zan\Framework\Network\Http\Exception\Handler\ForbiddenHandler::class,

    \ZanPHP\HttpServer\Middleware\Session::class => \Zan\Framework\Network\Http\Middleware\Session::class,
    \ZanPHP\HttpServer\Middleware\SessionFilter::class => \Zan\Framework\Network\Http\Middleware\SessionFilter::class,
    \ZanPHP\HttpServer\Middleware\SessionTerminator::class => \Zan\Framework\Network\Http\Middleware\SessionTerminator::class,

    \ZanPHP\HttpServer\Security\Csrf\Exception\TokenException::class => \Zan\Framework\Network\Http\Security\Csrf\Exception\TokenException::class,
    \ZanPHP\HttpServer\Security\Csrf\Factory\SimpleTokenFactory::class => \Zan\Framework\Network\Http\Security\Csrf\Factory\SimpleTokenFactory::class,
    \ZanPHP\HttpServer\Security\Csrf\Factory\TokenFactoryInterface::class => \Zan\Framework\Network\Http\Security\Csrf\Factory\TokenFactoryInterface::class,

    \ZanPHP\HttpServer\Security\Csrf\CsrfFilter::class => \Zan\Framework\Network\Http\Security\Csrf\CsrfFilter::class,
    \ZanPHP\HttpServer\Security\Csrf\CsrfToken::class => \Zan\Framework\Network\Http\Security\Csrf\CsrfToken::class,
    \ZanPHP\HttpServer\Security\Csrf\CsrfTokenManager::class => \Zan\Framework\Network\Http\Security\Csrf\CsrfTokenManager::class,
    \ZanPHP\HttpServer\Security\Csrf\CsrfTokenManagerInterface::class => \Zan\Framework\Network\Http\Security\Csrf\CsrfTokenManagerInterface::class,

    \ZanPHP\HttpServer\Security\Xss\XSSFilter::class => \Zan\Framework\Network\Http\Security\Xss\XSSFilter::class,

    \ZanPHP\HttpServer\ServerStart\InitializeExceptionHandlerChain::class => \Zan\Framework\Network\Http\ServerStart\InitializeExceptionHandlerChain::class,
    \ZanPHP\HttpServer\ServerStart\InitializeMiddleware::class => \Zan\Framework\Network\Http\ServerStart\InitializeMiddleware::class,
    \ZanPHP\HttpServer\ServerStart\InitializeProxyIps::class => \Zan\Framework\Network\Http\ServerStart\InitializeProxyIps::class,
    \ZanPHP\HttpServer\ServerStart\InitializeQiniuConfig::class => \Zan\Framework\Network\Http\ServerStart\InitializeQiniuConfig::class,
    \ZanPHP\HttpServer\ServerStart\InitializeRouter::class => \Zan\Framework\Network\Http\ServerStart\InitializeRouter::class,
    \ZanPHP\HttpServer\ServerStart\InitializeSqlMap::class => \Zan\Framework\Network\Http\ServerStart\InitializeSqlMap::class,
    \ZanPHP\HttpServer\ServerStart\InitializeUrlConfig::class => \Zan\Framework\Network\Http\ServerStart\InitializeUrlConfig::class,
    \ZanPHP\HttpServer\ServerStart\InitializeUrlRule::class => \Zan\Framework\Network\Http\ServerStart\InitializeUrlRule::class,

    \ZanPHP\HttpServer\Dispatcher::class => \Zan\Framework\Network\Http\Dispatcher::class,
    \ZanPHP\HttpServer\RequestExceptionHandlerChain::class => \Zan\Framework\Network\Http\RequestExceptionHandlerChain::class,
    \ZanPHP\HttpServer\RequestHandler::class => \Zan\Framework\Network\Http\RequestHandler::class,
    \ZanPHP\HttpServer\RequestTask::class => \Zan\Framework\Network\Http\RequestTask::class,
    \ZanPHP\HttpServer\Server::class => \Zan\Framework\Network\Http\Server::class,

];