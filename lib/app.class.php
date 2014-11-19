<?php

/**
 * 应用程序类
 */
class App {

	/**
	 * 程序版本号
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * 系统设置
	 * @var array
	 */
	private $_settings = array();

	/**
	 * 构造函数
	 */
	public function __construct() {}

	public function get($key) {
		$keys = explode('.', $key);
		return $_settings[$key];
	}

	/**
	 * 输出错误信息
	 * @param  string $code    错误代码
	 * @param  string $message 错误信息
	 * @return NULL
	 */
	public function error($code, $message = '') {
		print 'ERROR: [' . $code . '] ' . $message;
	}

	/**
	 * 计算字符串散列值
	 * @param  string $string 字符串
	 * @return string         散列值
	 */
	public function hash($string) {
		return hash('sha1', $string);
	}

	/**
	 * 页面重定向
	 * @param  string $url URL地址
	 * @return NULL
	 */
	public function redirect($url) {
		header('Location: ' . $url);
	}
}