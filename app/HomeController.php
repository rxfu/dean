<?php

class HomeController extends Controller {

	/**
	 * 网站主页
	 * @return void
	 */
	protected function index() {
		return $this->view->display('home.index');
	}

	/**
	 * 学生仪表盘
	 * @return void
	 */
	protected function student() {
		$message = DB::getInstance()->getColumn('SELECT text FROM t_xt_message');
		return $this->view->display('student.dashboard', array('message' => $message));
	}

	/**
	 * 教师仪表盘
	 * @return void
	 */
	protected function teacher() {
		return $this->view->display('teacher.dashboard');
	}
}