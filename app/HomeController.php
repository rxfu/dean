<?php

class HomeController extends Controller {

	/**
	 * 网站主页
	 * @return void
	 */
	protected function index() {
		return $this->view->display('home.index');
	}
	
}