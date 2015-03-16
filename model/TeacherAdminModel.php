<?php

/**
 * 教师管理模型类
 */
class TeacherAdminModel extends Model {

	public function __construct() {
		Config::set('db.default', Config::get('db.test.teacher'));
		$this->db = Database::getInstance();
	}

}
