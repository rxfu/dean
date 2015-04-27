<?php

/**
 * 生产环境数据库配置
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
return array(

	'db' => array(

		'student' => array(
			'engine'   => 'pgsql',
			'host'     => '202.193.162.26',
			'port'     => '5432',
			'dbname'   => 'dean',
			'username' => 's_web',
			'password' => '58ECTFD',
			'charset'  => 'UTF8',
		),
		'teacher' => array(
			'engine'   => 'pgsql',
			'host'     => '202.193.162.26',
			'port'     => '5432',
			'dbname'   => 'dean',
			'username' => 't_web',
			'password' => 'TFD58EC',
			'charset'  => 'UTF8',
		),
	),
);