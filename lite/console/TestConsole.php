<?php
/**
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 2017年02月21日
 * Time: 19:49:00
 */
namespace console;
use core\Console;
class TestConsole extends Console  {
    /**
     * 测试方法
     * @param string $param1
     * @param string $param2
     */
    public function TestAction($param1='',$param2=''){
        if($param1 && $param2){
            echo $param1 . $param2;die;
        }
        echo 1111;die;
    }

    /**
     * 生成自定义控制器模板方法
     * @param $controllerName
     */
    public function CreateAction($controllerName=""){
        if(!$controllerName){
            echo "请不要忘记输入要生成的控制器名\r\n";
        }
        $controllerName = ucfirst(strtolower($controllerName)) . "Controller";
        $path = USER_CONTROLLER_PATH . $controllerName . ".php";
        $str = file_get_contents(CONFIG_PATH . 'createTemplet');
        $str = str_replace('HelloController',$controllerName,$str);
        file_put_contents($path,$str);
    }
}