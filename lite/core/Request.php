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

    public function __construct()
    {
        $this->post();
        $this->get();
    }

    /**
     * 获取post请求
     * @param string $name 请求 缺省获取所有
     * @param string $isEncode 是否转义 默认按addslashes
     * 编码方式 默认addslashes编码，如果不想被转码，请传递 null
     * (如果值为base64，是base64解码)
     * @param boolean $isClear true的时候重新获取
     */
    public function post($name = '',$decode = 'addslashes',$isClear = false){
        if(!self::$get || $isClear){
            $this->__decode( $_POST ,$decode,self::$post);
        }
        return $name ? self::$post[$name] : self::$post;
    }

    /**
     * 获取get请求
     * @param string $name 请求 缺省获取所有
     * @param string $isEncode 是否转义 默认按addslashes
     * 编码方式 默认addslashes编码，如果不想被转码，请传递 null
     * (如果值为base64，是base64解码)
     * @param boolean $isClear true的时候重新获取
     */
    public function get($name = '' , $decode = 'addslashes' ,$isClear = false){
        if(!self::$get || $isClear){
             $this->__decode( $_GET ,$decode,self::$get);
        }
        return $name ? self::$get[$name] : self::$get;
    }

    /**
     * 递归调用返回被转码之后的数
     * @param mixed $array 要转码的数
     * @param string $decode
     */
    private function __decode($array,$decode,&$result){
        if(is_array($array)){
            foreach ($array as $key => $value){
                if(is_array($value)){
                     $this->__decode($array[$key],$decode,$result[$key]);
                }else{
                    switch ($decode){
                        case 'base64' :
                            $name = base64_decode($value);
                            break;
                        case 'addslashes' :
                            $name = addslashes($value);
                            break;
                        default :
                            $name = $value;
                            break;
                    }
                    $result[$key] = $name;
                }
            }
        }
        return $result;
    }
}