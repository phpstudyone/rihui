<?php
namespace core;
/**
 * 获取post get请求
 * Created by PhpStorm.
 * User: Winds10
 * Date: 2017/2/18
 * Time: 22:36
 */
class Request{
    /**
     * @var array post参数
     */
    public static $post;

    /**
     * @var array get参数
     */
    public static $get;

    /**
     * 获取post请求
     * @param string $name 请求 缺省获取所有
     * @param string $isEncode 是否转义 默认按addslashes
     *  false ： 直接获取
     *  base64decode
     */
    public function post($name = '',$isEncode = 'addslashes'){

    }

    /**
     * 获取get请求
     * @param string $name 请求 缺省获取所有
     * @param string $isEncode 是否转义 默认按addslashes
     *  false ： 直接获取
     *  base64
     */
    public function get($name = '' , $decode = '' , $isFilter = true){
        self::$post = $this->__decode($name ? $_GET[$name] : $_GET ,$decode,$isFilter);
    }

    /**
     * 返回被转码之后的数
     * @param $name
     * @param $encode
     * @return string
     */
    private function __decode($name,$decode,$isFilter){
        if(is_array($name)){
            foreach ($name as $key => $value){
                if(is_array($value)){
                    self::$post[$key] = $this->__decode($value,$decode,$isFilter);
                }else{
                    switch ($decode){
                        case 'base64' :
                            $name = base64_encode($name);
                            break;
                        default :
                            break;
                    }
                }
            }
        }
        return  $isFilter ? addslashes($name) : $name;
    }
}