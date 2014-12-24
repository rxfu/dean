<?php

class HomeController extends Controller {

	/**
	 * 网站主页
	 * @return void 
	 */
	public function index() {
		$this->view->render('student.login');
	}
}