<?php

class HomeController extends Controller {

	/**
	 * 网站主页
	 * @return void
	 */
	protected function index() {
		$this->view->render('student.login');
	}

	/**
	 * 网站仪表盘
	 * @return void
	 */
	protected function dashboard() {
		$this->view->render('home.dashboard');
	}
}