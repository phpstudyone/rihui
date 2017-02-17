<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2017/2/17
 * Time: 18:53
 */

/**
 * 定义路径分隔符
 */
defined("DS") or define('DS' , DIRECTORY_SEPARATOR);

/**
 * 定义配置文件路径
 */
define('CONFIG_PATH' , BASE_PATH . "config" . DS);

/**
 * 定义用户控制器路径
 */
define('USER_CONTROLLER_PATH' , BASE_PATH . 'userController' . DS);

/**
 * 定义用户控制器路径
 */
define('USER_MODEL_PATH' , BASE_PATH . 'userModel' . DS);
