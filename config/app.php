<?php

/**
 * 应用程序配置
 */
return array(

	// 系统参数
	'setting'    => array(
		'debug' => true,
	),

	// 默认路由
	'route'      => array(
		'default_controller' => 'home',
		'default_method'     => 'index',
	),

	// 用户参数
	'user'       => array(

		// 照片状态
		'portrait' => array(
			'none'     => '0',
			'uploaded' => '1',
			'passed'   => '2',
			'refused'  => '3',
		),

		// 学籍状态
		'status'   => '01',

		// 角色
		'role'     => array(
			'student' => 'student',
			'teacher' => 'teacher',
		),

		// 加密salt
		'salt'     => '+:sD>PjbsJ+3!&+TE@!J<:wj|*J6_KimvoHJ?HQ][vE)O/2S8F&<iz.-b#t2tW:|',
	),

	// 日志参数
	'log'        => array(
		'select'          => 'INSERT',
		'update'          => 'UPDATE',
		'drop'            => 'DELETE',
		'login'           => 'LOGIN',
		'logout'          => 'LOGOUT',
		'change_password' => 'CHGPWD',
		'register'        => 'REGIST',
		'cancel'          => 'CANCEL',
		'apply_course'    => 'APPLY',
		'revoke_course'   => 'REVOKE',
	),

	// 检索状态代码
	'course'     => array(

		// 课程类型
		'type'    => array(
			'bsc'    => array(
				'code' => 'BT',
				'name' => '公共课程',
			),
			'req'    => array(
				'code' => 'B',
				'name' => '必修课程',
			),
			'lct'    => array(
				'code' => 'X',
				'name' => '选修课程',
			),
			'hs'     => array(
				'code' => 'WT',
				'name' => '人文社科通识素质课程',
			),
			'ns'     => array(
				'code' => 'IT',
				'name' => '自然科学通识素质课程',
			),
			'as'     => array(
				'code' => 'YT',
				'name' => '艺术体育通识素质课程',
			),
			'os'     => array(
				'code' => 'QT',
				'name' => '其他专项通识素质课程',
			),
			'others' => array(
				'code' => 'OTHERS',
				'name' => '其他课程',
			),
			'retake' => array(
				'code' => 'RETAKE',
				'name' => '重修课程',
			),
		),

		// 可选状态
		'select'  => array(
			'forbidden'  => '0',
			'selected'   => '1',
			'selectable' => '2',
		),

		// 申请状态
		'apply'   => array(
			'unauditted' => '0',
			'passed'     => '1',
			'refused'    => '2',
			'others'     => '0',
			'retake'     => '1',
		),

		// 通识素质课
		'general' => array(
			'unlimited' => -1,
		),
	),

	// 成绩代码
	'score'      => array(
		'passline' => 60,

		// 提交状态
		'submit'   => array(
			'uncommitted'       => '0', // 未提交
			'committed'         => '1', // 教师已提交
			'college_confirmed' => '2', // 学院已确认
			'dean_confirmed'    => '3', // 教务处已确认
		),

		// 考试状态
		'exam'     => array(
			'deferral' => '1', // 缓考
		),
	),

	// 考试报名代码
	'exam'       => array(

		// 考试类型代码
		'type'   => array(
			'cet'  => '1',
			'cet3' => '03',
			'cet4' => '04',
			'cet6' => '06',
			'crt4' => '12',
			'cgt4' => '17',
			'cjt4' => '22',
			'cft4' => '23',
		),

		// 考试状态代码
		'status' => array(
			'register' => '1',
			'confirmed'   => '2',
			'payment'  => '3',
		),
	),

	// 文件上传参数
	'file'       => array(
		'file_uploads'        => 'on',
		'max_input_time'      => 90,
		'max_execution_time'  => 180,
		'post_max_size'       => 24, // 单位：MB
		'upload_max_filesize' => 20, // 单位：MB
		'memory_limit'        => 36, // 单位：MB
	),

	// 图片参数
	'image'      => array(
		'width'  => 240,
		'height' => 320,
	),

	'department' => array(
		'college'      => '1',
		'manager'      => '2',
		'organization' => '3',
		'industry'     => '4',
	),
);
