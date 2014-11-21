<?php

/**
 *  配置文件
 */

/**
 * 网站基本参数配置
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);
define('LIBROOT', ROOT . DS . 'lib');
define('APPROOT', ROOT . DS . 'app');
define('WEBROOT', ROOT . DS . 'web');
define('LOGROOT', ROOT . DS . 'log');

/**
 * 系统参数配置
 */
define('DEBUG', 0);

/**
 * 数据库参数配置
 */
define('DB_PREFIX', 'pgsql');
define('DB_HOST', '202.193.162.21');
define('DB_PORT', '5432');
define('DB_NAME', 'dean');
define('DB_USERNAME', 'jwxt');
define('DB_PASSWORD', 'jwxt..');
define('DB_CHARSET', 'UTF8');

/**
 * SALT配置
 */
define('AUTH_SALT', '+:sD>PjbsJ+3!&+TE@!J<:wj|*J6_KimvoHJ?HQ][vE)O/2S8F&<iz.-b#t2tW:|');

/**
 * 全局常量配置
 */
define('ENABLE', '1');
define('DISABLE', '0');