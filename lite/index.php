<?php
/**
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 17-2-18
 * Time: 上午12:55
 */
#!/usr/bin/env php

/**
 * 定义项目根目录
 */
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
require_once "core/Application.php";
defined('DEBUG') or define('DEBUG',true);
 \core\Application::run()->webApp();