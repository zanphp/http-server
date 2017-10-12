<?php
/**
 * Created by PhpStorm.
 * User: huye
 * Date: 2017/9/28
 * Time: 下午3:53
 */

namespace ZanPHP\HttpServer\Tests\Controller;
use ZanPHP\Framework\Foundation\Domain\HttpController as Controller;

class IndexController extends Controller {

    public function index()
    {
        $get = $this->request->all();
        if(!is_null($get))
            $msg = http_build_query($get);
        else
            $msg = '';
        $response =  $this->output($msg);
        yield $response;
    }
    public function customFilter()
    {
        $get = $this->request->all();
        if(!is_null($get))
            $msg = http_build_query($get);
        else
            $msg = '';
        $response =  $this->output($msg);
        yield $response;
    }
    public function sessionFilter()
    {
        $session = $this->context->get('session');
        $value = yield $session->get('skey');
        if(is_null($value)){
            yield $session->set('skey','zan_session');
            $out = array('exist'=>false);
        }
        else{
            $out = array('exist'=>true);
        }
        $response =  $this->output($out);
        yield $response;
    }


    public function exception()
    {
        throw new \Exception('test exception');
    }
}