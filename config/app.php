<?php

/**
 * 应用程序配置
 */
return array(

	// 系统参数
	'setting' => array(
		'debug' => true,
	),

	// 默认路由
	'route'   => array(
		'default_controller' => 'home',
		'default_method'     => 'index',
	),

	// 用户参数
	'user'    => array(
		'role' => array(
			'student' => 'student',
			'teacher' => 'teacher',
		),
		'salt' => '+:sD>PjbsJ+3!&+TE@!J<:wj|*J6_KimvoHJ?HQ][vE)O/2S8F&<iz.-b#t2tW:|',
	),

	// 日志参数
	'log'     => array(
		'select'          => 'INSERT',
		'update'          => 'UPDATE',
		'drop'            => 'DELETE',
		'login'           => 'LOGIN',
		'logout'          => 'LOGOUT',
		'change_password' => 'CHGPWD',
		'register'        => 'REGIST',
		'apply_course'    => 'APPLY',
	),

	// 检索状态代码
	'course'  => array(
		'type'    => array(
			'basic'    => array(
				'code' => 'bt',
				'name' => '公共课程',
			),
			'required' => array(
				'code' => 'b',
				'name' => '必修课程',
			),
			'elective' => array(
				'code' => 'x',
				'name' => '选修课程',
			),
			'humanity' => array(
				'code' => 'wt',
				'name' => '人文社科通识素质课程',
			),
			'natural'  => array(
				'code' => 'it',
				'name' => '自然科学通识素质课程',
			),
			'art'      => array(
				'code' => 'yt',
				'name' => '艺术体育通识素质课程',
			),
			'special'  => array(
				'code' => 'qt',
				'name' => '其他专项通识素质课程',
			),
			'others'   => array(
				'code' => 'others',
				'name' => '其他课程',
			),
			'retake'   => array(
				'code' => 'retake',
				'name' => '重修课程',
			),
		),
		'select'  => array(
			'forbidden'  => '0',
			'selectable' => '1',
			'selected'   => '2',
		),
		'apply'   => array(
			'unauditted' => '0',
			'passed'     => '1',
			'refused'    => '2',
			'others'     => '0',
			'retake'     => '1',
		),
		'general' => array(
			'unlimited' => -1,
		),
	),

	// 成绩状态代码
	'score'   => array(
		'passline'          => 60,
		'uncommitted'       => '0',
		'committed'         => '1',
		'college_confirmed' => '2',
		'dean_confirmed'    => '3',
	),

	// 考试报名状态代码
	'exam'    => array(
		'register' => '1',
		'passed'   => '2',
		'payment'  => '3',
	),

	// 文件上传参数
	'file'    => array(
		'file_uploads'        => 'on',
		'max_input_time'      => 90,
		'max_execution_time'  => 180,
		'post_max_size'       => 24, // 单位：MB
		'upload_max_filesize' => 20, // 单位：MB
		'memory_limit'        => 36, // 单位：MB
	),

	// 图片参数
	'image'   => array(
		'width'  => 240,
		'height' => 320,
	),
);
