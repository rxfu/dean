<?php

/**
 * 应用程序类，单例模式
 */
class App {

	use Singleton;

	/**
	 * 程序版本号
	 * @var string
	 */
	const VERSION = '1.2.0';

	/**
	 * 运行网站系统
	 * @return NULL
	 */
	public function run() {
		$this->setReporting();
		set_error_handler('error', E_USER_ERROR);

		Session::start();
		Route::dispatch();
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

}
