<?php

/**
 * 学生管理控制器
 */
class StudentAdminController extends Controller {

	/**
	 * 控制器构造方法
	 */
	public function __construct() {
		$this->before_excepts = array('login', 'auth', 'logout');
		// $this->db             = Database::getInstance(DB_STU_ENGINE, DB_STU_HOST, DB_STU_PORT, DB_STU_DBNAME, DB_STU_USERNAME, DB_STU_PASSWORD, DB_STU_CHARSET);
		Config::set('db.default', Config::get('db.dev.student'));
		$this->db = Database::getInstance();

		parent::__construct();
	}

	/**
	 * 继承自基类before方法
	 * @return NULL
	 */
	protected function before() {
		parent::before();

		if (!$this->session->isValid(Config::get('session.ttl')) || Config::get('user.role.student') != $this->session->get('role')) {
			return redirect('student.login');
		}
	}

}