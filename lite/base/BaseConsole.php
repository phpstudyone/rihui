<?php
namespace base;
use core\Console;

/**
 * 父类控制器
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 2017年02月21日
 * Time: 19:49:00
 */
class BaseConsole extends Console  {
    /**
     * 控制器默认的方法
     */
    public function IndexAction(){
        echo "这里是父类控制器BaseController的index方法。\r\n";
        echo "如果你看到了这句话，请检查你的控制器代码是否没有重写index方法且命令行没有输入actionName\r\n";
        die;
    }
}