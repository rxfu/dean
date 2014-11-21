<?php

/**
 * 网站启动文件
 */
require_once 'config.php';

require_once LIBROOT . DS . 'autoloader.class.php';
Autoloader::register();

require_once 'routes.php';

$app = App::getInstance();
$app->run();