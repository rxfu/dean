<?php

/**
 * 学生管理模型类
 */
class StudentAdminModel extends Model {

	public function __construct() {
		Config::set('db.default', Config::get('db.test.student'));
		$this->db = Database::getInstance();
	}

}
