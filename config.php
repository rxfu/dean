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
define('MODROOT', ROOT . DS . 'model');
define('PUBROOT', ROOT . DS . 'public');
define('LOGROOT', ROOT . DS . 'log');
define('STORAGE', ROOT . DS . 'storage');
define('PORTRAIT', STORAGE . DS . 'portraits');
define('SESSION', STORAGE . DS . 'sessions');

/**
 * 系统参数配置
 */
define('DEBUG', 1);

/**
 * 数据库参数配置
 */
/*
define('DB_PREFIX', 'pgsql');
define('DB_HOST', '202.193.162.21');
define('DB_PORT', '5432');
define('DB_NAME', 'dean');
define('DB_USERNAME', 'jwxt');
define('DB_PASSWORD', 'jwxt..');
define('DB_CHARSET', 'UTF8');
 */
/*
define('DB_PREFIX', 'pgsql');
define('DB_HOST', '202.193.171.253');
define('DB_PORT', '5432');
define('DB_NAME', 'dean');
define('DB_USERNAME', 'jwxt');
define('DB_PASSWORD', 'jwxt..');
define('DB_CHARSET', 'UTF8');
 */

define('DB_STU_ENGINE', 'pgsql');
define('DB_STU_HOST', '202.193.171.253');
define('DB_STU_PORT', '5432');
define('DB_STU_DBNAME', 'dean');
define('DB_STU_USERNAME', 'jwxt');
define('DB_STU_PASSWORD', 'jwxt..');
define('DB_STU_CHARSET', 'UTF8');

define('DB_TCH_ENGINE', 'pgsql');
define('DB_TCH_HOST', '202.193.171.253');
define('DB_TCH_PORT', '5432');
define('DB_TCH_DBNAME', 'dean');
define('DB_TCH_USERNAME', 'jwxt');
define('DB_TCH_PASSWORD', 'jwxt..');
define('DB_TCH_CHARSET', 'UTF8');

/*
define('DB_STU_ENGINE', 'pgsql');
define('DB_STU_HOST', '202.193.171.253');
define('DB_STU_PORT', '5432');
define('DB_STU_DBNAME', 'dean');
define('DB_STU_USERNAME', 's_web');
define('DB_STU_PASSWORD', 's_web.0');
define('DB_STU_CHARSET', 'UTF8');

define('DB_TCH_ENGINE', 'pgsql');
define('DB_TCH_HOST', '202.193.171.253');
define('DB_TCH_PORT', '5432');
define('DB_TCH_DBNAME', 'dean');
define('DB_TCH_USERNAME', 't_web');
define('DB_TCH_PASSWORD', 't_web.0');
define('DB_TCH_CHARSET', 'UTF8');
*/
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
 * 默认路由配置
 */
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_METHOD', 'index');

/**
 * 会话参数配置
 */
define('SESSION_KEY', 'GXNUAcademicManageSystem');
define('SESSION_NAME', 'GXNUAMS');
define('SESSION_PREFIX', 'dean_');
define('SESSION_TTL', 120); // 单位：分钟

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
define('FORBIDDEN', '0');
define('SELECTABLE', '1');
define('SELECTED', '2');

/**
 * 考试状态代码
 */
define('PASSLINE', 60);
define('UNCOMMITTED', '0');
define('COMMITTED', '1');
define('COLLEGE_CONFIRMED', '1');
define('DEAN_CONFIRMED', '2');
define('NORMAL', '正常');
define('ABSENCE', '缺考');

/**
 * 用户角色代码
 */
define('STUDENT', 'student');
define('TEACHER', 'teacher');

/**
 * 审核状态代码
 */
define('UNAUDITTED', '0');
define('PASSED', '1');
define('REFUSED', '2');

/**
 * 课程类型代码
 */
define('BASIC', 'bsc');
define('REQUIRED', 'req');
define('ELECTIVE', 'lct');
define('HUMANITY', 'hs');
define('NATURAL', 'ns');
define('ART', 'as');
define('SPECIAL', 'os');
define('OTHERS', 'others');
define('RETAKE', 'retake');

/**
 * 课程申请类型代码
 */
define('APPLY_OTHERS', '0');
define('APPLY_RETAKE', '1');

/**
 * 选课状态代码
 */
define('COURSE_UNLIMITED', -1);
