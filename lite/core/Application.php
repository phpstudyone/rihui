<?php
namespace core;
/**
 * 应用主体文件
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/2/17
 * Time: 18:06
 */
class Application
{
    public $app;
    /**
     * 应用启动方法，加载配置文件、各种必须文件，初始化工作等
     */
    public static function run(){
        require_once 'define.php';
        /**
         * composer 第三方包自动加载代码
         */
        require CORE_PATH . 'vendor/autoload.php';
        /**
         * 注册框架本事自动加载函数
         */
        spl_autoload_register('self::auto');
        $db = Config::getConfig('db');
        return new self();
    }

    /**
     * webApp
     */
    public function webApp(){
        if(DEBUG){
            ini_set("display_errors", "On");
            error_reporting(E_ALL | E_STRICT);
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }
    }

    /**
     * 命令行
     * @param $argv
     */
    public function console($argv){
        $controller = ucfirst(strtolower($argv[1]));
        $controllerName = $controller . "Controller";
        $object = '\\userController\\' . $controllerName;
        $object = new $object;
        if(!isset($argv[2])){
            $object->IndexAction();
        }else{
            $action = ucfirst(strtolower($argv[2])) . "Action";
            if(!method_exists($object,$action)){
                echo $argv[2] . "方法不存在\r\n";die;
            }else{
                $count = count($argv);
                $str = '$object->' . $action;
                if ($count == 3){
                    $str .= '();';
                }else{
                    $str .= "(";
                    for($i = 4 ; $i <= $count ; $i++){
                        $str .= "'" . $argv[$i-1] . "'" ;
                        if($i != $count){
                            $str .= ",";
                        }
                    }
                    $str .= ");";
                }
                eval($str);
            }
        }
    }

    /**
     * 自动加载类
     * @param $className
     */
    public static function auto($className){
        $file = $className . ".php" ;
        $filePath = '';
        if(strstr($className,'\\')){
            $filePath = str_replace('\\','/',$file);
            $filePath = BASE_PATH . DS . $filePath;
        }else{
            if(strpos($className,'Controller')){
                $filePath = USER_CONTROLLER_PATH . $file;
            }elseif (strpos($className,'Model')){
                $filePath = USER_MODEL_PATH . $file;
            }else{
                //your code.....
            }
        }
        if( !file_exists($filePath) ){
            echo $filePath . "控制器文件不存在\r\n";die;
        }
        require_once $filePath;
    }
}