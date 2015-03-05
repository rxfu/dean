<?php

/**
 * 教师管理模型类
 */
class TeacherAdminModel extends Model {

	public function __construct() {
		// $this->db             = Database::getInstance(DB_TCH_ENGINE, DB_TCH_HOST, DB_TCH_PORT, DB_TCH_DBNAME, DB_TCH_USERNAME, DB_TCH_PASSWORD, DB_TCH_CHARSET);
		Config::set('db.default', Config::get('db.dev.teacher'));
		$this->db = Database::getInstance();
	}

}
