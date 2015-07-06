<?php

/**
 * 开发环境数据库配置
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
			'username' => 'jwxt',
			'password' => 'jwxt..',
			'charset'  => 'UTF8',
		),
		'teacher' => array(
			'engine'   => 'pgsql',
			'host'     => '202.193.171.253',
			'port'     => '5432',
			'dbname'   => 'deantest',
			'username' => 'jwxt',
			'password' => 'jwxt..',
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