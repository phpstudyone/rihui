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
     * @return mixed
     */
    public static function getConfig($name = ''){
        if(!self::$config){
            self::$config = require_once CONFIG_PATH . 'main.php';
        }
        return $name ? self::$config[$name] : self::$config;
    }
}