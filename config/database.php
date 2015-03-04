<?php

/**
 * 数据库配置
 */
return array(

	'db' => array(

		// 默认环境
		'default' => array(
			'engine'   => 'pgsql',
			'host'     => 'localhost',
			'port'     => '5432',
			'dbname'   => 'database',
			'username' => 'dean',
			'password' => '',
			'charset'  => 'UTF8',
		),

		// 开发环境
		'dev'     => array(
			'student' => array(
				'engine'   => 'pgsql',
				'host'     => '202.193.171.253',
				'port'     => '5432',
				'dbname'   => 'dean',
				'username' => 'jwxt',
				'password' => 'jwxt..',
				'charset'  => 'UTF8',
			),
			'teacher' => array(
				'engine'   => 'pgsql',
				'host'     => '202.193.171.253',
				'port'     => '5432',
				'dbname'   => 'dean',
				'username' => 'jwxt',
				'password' => 'jwxt..',
				'charset'  => 'UTF8',
			),
		),

		// 测试环境
		'test'    => array(
			'student' => array(
				'engine'   => 'pgsql',
				'host'     => '202.193.171.253',
				'port'     => '5432',
				'dbname'   => 'dean',
				'username' => 's_web',
				'password' => 's_web.0',
				'charset'  => 'UTF8',
			),
			'teacher' => array(
				'engine'   => 'pgsql',
				'host'     => '202.193.171.253',
				'port'     => '5432',
				'dbname'   => 'dean',
				'username' => 't_web',
				'password' => 't_web.0',
				'charset'  => 'UTF8',
			),
		),

		// 生产环境
		'prod'    => array(
			'student' => array(
				'engine'   => 'pgsql',
				'host'     => '202.193.171.253',
				'port'     => '5432',
				'dbname'   => 'dean',
				'username' => 's_web',
				'password' => '58ECTFD',
				'charset'  => 'UTF8',
			),
			'teacher' => array(
				'engine'   => 'pgsql',
				'host'     => '202.193.171.253',
				'port'     => '5432',
				'dbname'   => 'dean',
				'username' => 't_web',
				'password' => 'TFD58EC',
				'charset'  => 'UTF8',
			),
		),
	),
);