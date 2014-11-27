<?php

/**
 * 控制类
 */
class Controller {

	/**
	 * 控制器对应视图
	 * @var View
	 */
	protected $view = null;

	/**
	 * 控制器构造方法
	 */
	public function __construct() {
		$this->view = new View();
	}

	/**
	 * 判断请求是否采用POST方法
	 * @return boolean 请求为POST方法为TRUE，否则为FALSE
	 */
	protected function isPost() {
		return 'POST' === $_SERVER['REQUEST_METHOD'];
	}
}