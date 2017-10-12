<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/29
 * Time: 上午11:18
 */

namespace ZanPHP\HttpServer\Tests\Middleware;

use ZanPHP\Contracts\Network\Request;
use ZanPHP\Coroutine\Context;
use ZanPHP\Framework\Contract\Network\RequestFilter;

class TestCustomFilter implements RequestFilter
{
    /**
     * @param \ZanPHP\HttpFoundation\Request\Request $request
     * @param \ZanPHP\Coroutine\Context $context
     * @return \Generator*
     **/
    public function doFilter(Request $request, Context $context)
    {
        $input = array(
            'test' => 'TestCustomFilter'
        );
        $request->replace($input);

        yield null;
    }
}