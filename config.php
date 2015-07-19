<?php

/**
 * 配置文件
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */

/**
 * 网站所在目录
 */
define('VD', substr(strrchr(dirname(__FILE__), DS), 1));

/**
 * 网站基本参数配置
 */
define('CFGROOT', ROOT . DS . 'config');
define('LIBROOT', ROOT . DS . 'lib');
define('APPROOT', ROOT . DS . 'app');
define('WEBROOT', ROOT . DS . 'web');
define('MODROOT', ROOT . DS . 'model');
define('PUBROOT', ROOT . DS . 'public');
define('LOGROOT', ROOT . DS . 'log');
define('STORAGE', ROOT . DS . 'storage');
define('VENDOR', ROOT . DS . 'vendor');
define('PORTRAIT', STORAGE . DS . 'portraits');
define('PHOTO', STORAGE . DS . 'photos');
define('SESSION', STORAGE . DS . 'sessions');
define('CACHE', STORAGE . DS . 'cache');

/**
 * 全局常量配置
 */
define('ENABLE', '1');
define('DISABLE', '0');
