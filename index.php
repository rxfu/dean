<?php

/**
 * 网站启动文件
 */
require 'globals.php';
require LIBROOT . DIRECTORY_SEPARATOR . 'autoloader.class.php';

Autoloader::register();

$cfg = Configuration::getInstance();
$cfg->load();

$app = App::getInstance();
$app->run();