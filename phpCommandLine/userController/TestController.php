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
    public function TestAction($param1='',$param2=''){
        if($param1 && $param2){
            echo $param1 . $param2;die;
        }
        echo 1111;die;
    }
}
return __NAMESPACE__;