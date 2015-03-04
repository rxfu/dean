<?php

/**
 * 学生管理模型类
 */
class StudentAdminModel extends Model {

	public function __construct() {
		// $this->db             = Database::getInstance(DB_STU_ENGINE, DB_STU_HOST, DB_STU_PORT, DB_STU_DBNAME, DB_STU_USERNAME, DB_STU_PASSWORD, DB_STU_CHARSET);
		$this->db = Database::getInstance(TEST_STU_ENGINE, TEST_STU_HOST, TEST_STU_PORT, TEST_STU_DBNAME, TEST_STU_USERNAME, TEST_STU_PASSWORD, TEST_STU_CHARSET);
	}

}
