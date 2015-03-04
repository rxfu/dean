<?php

/**
 * 错误控制器
 */
class ErrorController extends Controller {

	/**
	 * 错误页面
	 * @return object
	 */
	protected function error() {
		return $this->view->display('error.index', array('error' => $this->session->get('error')));
	}

}
