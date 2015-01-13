<?php

class HomeController extends Controller {

	/**
	 * 网站主页
	 * @return void
	 */
	protected function index() {
		return $this->view->display('student.login');
	}

	/**
	 * 网站仪表盘
	 * @return void
	 */
	protected function dashboard() {
		return $this->view->display('home.dashboard');
	}
}