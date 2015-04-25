<?php

/**
 * 网站入口类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
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