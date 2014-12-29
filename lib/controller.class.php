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
	 * 方法前过滤提交变量
	 * @param  string $method    方法名
	 * @param  array $arguments 方法参数
	 * @return mixed            方法返回值
	 */
	public function __call($method, $arguments) {
		if (method_exists($this, $method)) {
			$this->before();
			$beforeMethod = 'before_' . $method;
			if (method_exists($this, $beforeMethod)) {
				if (call_user_func_array(array($this, $beforeMethod), $arguments)) {
					call_user_func_array(array($this, $method), $arguments);
				}
			} else {
				call_user_func_array(array($this, $method), $arguments);
			}

			$afterMethod = 'after_' . $method;
			if (method_exists($this, $afterMethod)) {
				call_user_func_array(array($this, $afterMethod), $arguments);
			}
			$this->after();
		}
	}

	/**
	 * 预先执行函数
	 * @return NULL
	 */
	protected function before() {
		$_POST    = isset($_POST) ? sanitize($_POST) : null;
		$_GET     = isset($_GET) ? sanitize($_GET) : null;
		$_REQUEST = isset($_REQUEST) ? sanitize($_REQUEST) : null;
		$_COOKIE  = isset($_COOKIE) ? sanitize($_COOKIE) : null;
	}

	/**
	 * 事后执行函数
	 * @return NULL
	 */
	protected function after() {
		// TODO:
	}

}