<?php

/**
 * 网站入口
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */

/**
 * 网站根目录
 */
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('ROOT', dirname(__DIR__));

/**
 * 网站启动文件
 */
require_once ROOT . DS . 'config.php';
require_once LIBROOT . DS . 'helpers.php';

require_once LIBROOT . DS . 'autoloader.php';
Autoloader::register();

$app = App::getInstance();
$app->run();