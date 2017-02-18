<?php
namespace core;

/**
 * 路由方法，控制url
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/2/17
 * Time: 18:08
 */
class Router{
    /**
     * 路由分发，接受的是$_SERVER['REQUEST_URI']
     * eg  : /test/test/id/54/name/56
     * 表示访问Test控制器test方法，get传递id参数，值为54，name参数值为56
     * @param $str
     */
    public static function distribute($str){
        $a = Config::getConfig('default_action',true);
        dump($str,$a);
        (new Request())->get();
    }
}