<?php

class HomeController extends Controller {

	/**
	 * 网站主页
	 * @return void
	 */
	protected function index() {
		return $this->view->render('student.login');
	}

	/**
	 * 网站仪表盘
	 * @return void
	 */
	protected function dashboard() {
		return $this->view->render('home.dashboard');
	}
}