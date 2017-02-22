<?php
/**
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 17-2-11
 * Time: 下午10:04
 */
namespace userController;
use base\BaseController;

class TestController extends BaseController  {
    /**
     * 测试方法
     * @param string $param1
     * @param string $param2
     */
    public function TestAction(){
        dump($this->request->get('c'));
        dump($this);
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