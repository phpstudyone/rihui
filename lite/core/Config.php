<?php
namespace core;
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/2/17
 * Time: 18:09
 */
class Config{

    public static $config;

    /**
     * 获取配置文件内容
     * @param string $name 配置项 缺省返回所有
     * @param boolean $debug false or true .
     *  为false时，当配置项不存在时，返回false。
     *  为true时，当配置项不存在时，抛出异常
     * @return mixed 配置内容
     * @throws \Exception
     */
    public static function getConfig($name = '',$debug = false)
    {
        if(!self::$config){
            self::$config = require_once CONFIG_PATH . 'main.php';
        }
        if($name){
            if (isset(self::$config[$name])){
                return self::$config[$name] ;
            }else{
                if($debug) {
                    return false;
                }else{
                    throw new \Exception('没有该项配置，请检查配置文件');
                }
            }
        }else{
            return self::$config;
        }
    }
}