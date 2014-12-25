<?php

class HomeController extends Controller {

	/**
	 * 网站主页
	 * @return void
	 */
	public function index() {
		$this->view->render('student.login');
	}

	/**
	 * 网站仪表盘
	 * @return void
	 */
	public function dashboard() {
		$this->view->render('home.dashboard');
	}
}