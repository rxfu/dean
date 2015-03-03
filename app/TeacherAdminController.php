<?php

/**
 * 教师管理控制器
 */
class TeacherAdminController extends Controller {

	/**
	 * 控制器构造方法
	 */
	public function __construct() {
		$this->before_excepts = array('login', 'auth', 'logout');
		// $this->db             = Database::getInstance(DB_TCH_ENGINE, DB_TCH_HOST, DB_TCH_PORT, DB_TCH_DBNAME, DB_TCH_USERNAME, DB_TCH_PASSWORD, DB_TCH_CHARSET);
		$this->db = Database::getInstance(TEST_TCH_ENGINE, TEST_TCH_HOST, TEST_TCH_PORT, TEST_TCH_DBNAME, TEST_TCH_USERNAME, TEST_TCH_PASSWORD, TEST_TCH_CHARSET);

		parent::__construct();
	}

	/**
	 * 继承自基类before方法
	 * @return NULL
	 */
	protected function before() {
		parent::before();

		if (!$this->session->isValid() || TEACHER != $this->session->get('role')) {
			return redirect('teacher.login');
		}
	}

}