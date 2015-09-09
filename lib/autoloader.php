<?php

/**
 * 自动加载类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class Autoloader {

	/**
	 * 自动加载类对象
	 * @var object
	 */
	private static $loader;

	/**
	 * 构造函数
	 */
	public function __construct() {
		spl_autoload_register(array($this, 'controller'));
		spl_autoload_register(array($this, 'model'));
		spl_autoload_register(array($this, 'library'));
	}

	/**
	 * 注册autoloader
	 * @return object
	 */
	public static function register() {
		if (NULL == self::$loader) {
			self::$loader = new self();
		}

		return self::$loader;
	}

	/**
	 * 自动加载控制器类
	 * @param  string $class 类名
	 * @return void
	 */
	private function controller($class) {
		if (preg_match('/^.+Controller$/ui', $class)) {
			require APPROOT . DS . $class . '.php';
		}
	}

	/**
	 * 自动加载模型类
	 * @param  string $class 类名
	 * @return void
	 */
	private function model($class) {
		if (preg_match('/^.+Model$/ui', $class)) {
			require MODROOT . DS . $class . '.php';
		}
	}

	/**
	 * 自动加载系统库类
	 * @param  string $class 类名
	 * @return void
	 */
	private function library($class) {
		$class = camelToSnake($class);

		if (file_exists(LIBROOT . DS . $class . '.php')) {
			require LIBROOT . DS . $class . '.php';
		}
	}

}