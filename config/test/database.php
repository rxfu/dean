<?php

/**
 * 测试环境数据库配置
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
return array(

	'db' => array(

		'student' => array(
			'engine'   => 'pgsql',
			'host'     => '202.193.171.253',
			'port'     => '5432',
			'dbname'   => 'deantest',
			'username' => 's_web',
			'password' => 's_web.0',
			'charset'  => 'UTF8',
		),
		'teacher' => array(
			'engine'   => 'pgsql',
			'host'     => '202.193.171.253',
			'port'     => '5432',
			'dbname'   => 'deantest',
			'username' => 't_web',
			'password' => 't_web.0',
			'charset'  => 'UTF8',
		),
		'tassess' => array(
			'engine'   => 'pgsql',
			'host'     => '202.193.171.253',
			'port'     => '5432',
			'dbname'   => 'jxpg',
			'username' => 'jwxt',
			'password' => 'jwxt..',
			'charset'  => 'UTF8',
		),
	),
);