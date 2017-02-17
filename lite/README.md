个人自用PHP lite 框架
====================

**最开始本来只是想做一个php的命令行工具，
但是做的时候考虑的太多，慢慢实现下来，发现有了框架的雏形
索性就慢慢扩展它～文件名也从phpCommand变为了lite**

# 命令行篇 #
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
```
* 命名空间需要和文件路径保持一致
* 必须在userController文件夹下
* 必须继承父类BaseController
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
```
你也可以自定义你的模板文件，模板文件为config/createTemplet

**删除了必须返回命名空间的限制**

# webApp篇 #

    框架引入第三方打印类sysmfony/var_dump，
    函数dump和php内置var_dump用法一致，不过更友好
    更多用法点击查看文档：[sysmfony/var_dump](https://symfony.com/doc/current/components/var_dumper.html)

    引入第三方debug类filp/whoops,非常酷炫的效果
    更多用法点击查看文档：[filp/whoops](https://packagist.org/packages/filp/whoops)