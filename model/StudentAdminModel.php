<?php

/**
 * 学生管理模型类
 */
class StudentAdminModel extends Model {

	public function __construct() {
		// $this->db             = Database::getInstance(DB_STU_ENGINE, DB_STU_HOST, DB_STU_PORT, DB_STU_DBNAME, DB_STU_USERNAME, DB_STU_PASSWORD, DB_STU_CHARSET);
		Config::set('dv.default', Config::Get('db.dev.student'));
		$this->db = Database::getInstance();
	}

}
