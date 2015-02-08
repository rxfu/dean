<?php

/**
 * 应用程序类
 */
class App extends Prefab {

	/**
	 * 程序版本号
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * 运行网站系统
	 * @return NULL
	 */
	public function run() {
		$this->setReporting();
		set_error_handler('error', E_USER_ERROR);
		Session::start();

		if (isset($_GET['url'])) {
			$this->call($_GET['url']);
		} else {
			$this->call();
		}

		Session::close();
	}

	/**
	 * 设置调试状态下错误报告模式
	 */
	public function setReporting() {
		if (DEBUG) {
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors', 'Off');
			ini_set('log_errors', 'On');
			ini_set('error_log', LOGROOT . DS . 'error.log');
		}
	}

	/**
	 * 请求执行控制器中方法
	 * @param  string $url 请求URL
	 * @return NULL
	 */
	public function call($url = NULL) {
		$url                                     = is_null($url) ? '/' : $url;
		list($controller, $action, $queryString) = Route::parse($url);
		$controller                              = ucwords($controller) . 'Controller';
		$dispatch                                = new $controller;
		if (method_exists($dispatch, $action)) {
			call_user_func_array(array($dispatch, $action), $queryString);
		} else {
			throw new RuntimeException('方法 ' . $action . ' 在类 ' . $controller . ' 中不存在');
		}
	}

}
