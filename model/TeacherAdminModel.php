<?php

/**
 * 教师管理模型类
 */
class TeacherAdminModel extends Model {

	public function __construct() {
		$this->setRole(Config::get('user.role.teacher'));
		parent::__construct();
	}

}
