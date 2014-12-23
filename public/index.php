<?php

/**
 * 网站根目录
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));

/**
 * 网站启动文件
 */
require_once ROOT . DS . 'config.php';
require_once LIBROOT . DS . 'helpers.php';

require_once LIBROOT . DS . 'autoloader.class.php';
Autoloader::register();

require_once ROOT . DS . 'routes.php';

$app = App::getInstance();
$app->run();