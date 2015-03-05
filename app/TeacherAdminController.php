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
		Config::set('db.default', Config::get('db.dev.teacher'));
		$this->db = Database::getInstance();

		parent::__construct();
	}

	/**
	 * 继承自基类before方法
	 * @return NULL
	 */
	protected function before() {
		parent::before();

		if (!$this->session->isValid() || Config::get('user.role.teacher') != $this->session->get('role')) {
			return redirect('teacher.login');
		}
	}

}