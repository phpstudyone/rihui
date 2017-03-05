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
        $index = strpos($str,'?');
        if ($index !== false){
            $str = substr($str,0,$index);
        }
        $str =trim($str,'/');
        $strArr = explode('/',$str);
        if(!isset($strArr[0]) || !$strArr[0]){
            $default_router = Config::getConfig('default_router',true);
            $controller = isset($default_router['controller']) ? $default_router['controller'] : false;
            $_GET['controller'] = $controller ? $controller : DEFAULT_CONTROLLER;
        }else{
            $_GET['controller'] = $strArr[0];
        }
        if(isset($strArr[1]) && $strArr[1]){
            $_GET['action'] = $strArr[1];
        }else{
            $default_router = Config::getConfig('default_router',true);
            $action= isset($default_router['action']) ? $default_router['action'] : false;
            $_GET['action'] = $action ? $action : DEFAULT_ACTION;
        }

        $count = count($strArr);
        if($count >= 3){
            for ($i=2 ; $i < $count ; $i = $i+2){
                $_GET[$strArr[$i]] = isset($strArr[$i+1]) ? $strArr[$i+1] : '' ;
            }
        }
        $request = new Request();
        $controller = ucfirst(strtolower($request->get('controller')));
        $controllerName = $controller . "Controller";
        $object = '\\userController\\' . $controllerName;
        $object = new $object;
        $action = ucfirst(strtolower($request->get('action'))) . "Action";
        $object->$action();
    }
}