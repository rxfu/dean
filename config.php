<?php

/**
 *  配置文件
 */

/**
 * 网站所在目录
 */
define('VD', substr(strrchr(dirname(__FILE__), DS), 1));

/**
 * 网站基本参数配置
 */
define('LIBROOT', ROOT . DS . 'lib');
define('APPROOT', ROOT . DS . 'app');
define('WEBROOT', ROOT . DS . 'web');
define('PUBROOT', ROOT . DS . 'public');
define('LOGROOT', ROOT . DS . 'log');
define('STORAGE', ROOT . DS . 'storage');
define('PORTRAIT', STORAGE . DS . 'portraits');

/**
 * 系统参数配置
 */
define('DEBUG', 1);

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

/**
 * 会话参数配置
 */
define('SESS_EXPIRATION', 7200);

/**
 * 日志操作类型配置
 */
define('LOG_INSERT', 'INSERT');
define('LOG_UPDATE', 'UPDATE');
define('LOG_DELETE', 'DELETE');
define('LOG_LOGIN', 'LOGIN');
define('LOG_LOGOUT', 'LOGOUT');
define('LOG_CHGPWD', 'CHGPWD');
define('LOG_REGIST', 'REGIST');
define('LOG_APPLY', 'APPLY');

/**
 * 分页配置
 */
define('PAGE_INIT', 1);
define('PAGE_SIZE', 10);

/**
 * 检索状态代码
 */
define('DISABLE', 0);
define('ENABLE', 1);
define('SELECTED', 2);
