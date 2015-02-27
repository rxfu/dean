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

		parent::__construct();
	}

	/**
	 * 继承自基类before方法
	 * @return NULL
	 */
	protected function before() {
		parent::before();

		if (!Session::isStarted() || TEACHER != $this->session->get('role')) {
			redirect('teacher.login');
		}
	}

}