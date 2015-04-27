<?php

/**
 * 学生管理控制器
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class StudentAdminController extends Controller {

	/**
	 * 控制器构造方法
	 */
	public function __construct() {
		parent::__construct();

		$this->before_excepts = array('login', 'auth', 'logout');
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