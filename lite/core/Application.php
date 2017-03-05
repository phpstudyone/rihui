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
        try{
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
        }catch (\Exception $e){
            //做一些日志记录之类的工作
            /**
             * 事实上，因为异常或者错误信息，都被第三方Whoops给接受了，
             * 所以这里是无法捕获到异常的，把这个try-catch放在webApp方法能
             * 捕获到异常但是又无法使用第三方Whoops。。。。。
             * 也许需要重写Whoops方法，或者看看是否有提供api
             */
        }
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
        Router::distribute($_SERVER['REQUEST_URI']);
    }

    /**
     * 命令行
     * @param $argv
     */
    public function console($argv){
        $console = ucfirst(strtolower($argv[1]));
        $consoleName = $console . "Console";
        $object = '\\console\\' . $consoleName;
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