<?php

class HomeController extends Controller {

	/**
	 * 网站主页
	 * @return void
	 */
	protected function index() {
		if ($this->session->get('logged')) {
			$this->session->forget();
		}
		
		return $this->view->display('home.index');
	}
	
}