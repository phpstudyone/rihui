<?php
namespace base;
use core\Controller;

/**
 * 父类控制器
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 17-2-11
 * Time: 下午10:13
 */
class BaseController extends Controller  {
    /**
     * 控制器默认的方法
     */
    public function IndexAction(){
        echo "这里是父类控制器BaseController的index方法。\r\n";
        echo "如果你看到了这句话，请检查你的控制器代码是否没有重写index方法且命令行没有输入actionName\r\n";
        die;
    }
}