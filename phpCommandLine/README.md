phpcli 模式执行php文件
====================

##一：运行格式
请使用以下格式命令来运行
```sh
./userCommand controllerName actionName param1 param2 .....
```
其中 
    ./userCommand 是入口文件，必须
    controllerName为控制器名，必须
    actionName为控制器中方法名，非必须,缺省状态下默认为 index action
    param1 ...  为方法中需要传递的参数，非必须，视具体情况而定。

##二：demo解释
请使用以下格式命令来运行
```sh
./userCommand test test hello world
```
此条命令会执行 TestController.php 文件下 TestAction 方法。
