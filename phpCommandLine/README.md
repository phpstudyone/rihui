phpcli 模式执行php文件
====================

##一：运行格式
请使用以下格式命令来运行
```sh
./userCommand controllerName actionName param1 param2 .....
```
其中 
* ./userCommand 是入口文件，必须
* controllerName为控制器名，必须
* actionName为控制器中方法名，非必须,缺省状态下默认为 index action
* param1 ...  为方法中需要传递的参数，非必须，视具体情况而定。

##二：demo解释
请使用以下格式命令来运行
```sh
./userCommand test test hello world
```
此条命令会执行 TestController.php 文件下 TestAction 方法。

##三：用户自定义控制器规则
``` php
namespace userController;
use base\BaseController;
class NameController extends BaseController  {
    //...your code..
}
return __NAMESPACE__;
```
* 必须在userController文件夹下
* 必须继承父类BaseController
* 必须类外返回该类的命名空间
* 必须大写类名首字母，其他小写，以Controller结尾
* 必须大写方法名首字母，其他小写，以Action结尾


恩，限制条件比较多，所以这里提供了一个命令，用于生成自定义控制器代码
``` sh
./userCommand test create hello
```
其中hello为需要生成的控制器名，生成的代码文件为 `HelloController.php`：
HelloController.php文件内容为：
``` php
<?php
namespace userController;
use base\BaseController;
class HelloController extends BaseController  {
    public function IndexAction($param1='',$param2=''){
        var_dump($param1,$param1);
    }
}
return __NAMESPACE__;
```
你也可以自定义你的模板文件，模板文件为config/createTemplet