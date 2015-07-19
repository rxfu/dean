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
	public function controller($class) {
		$class = preg_replace('/Controller$/ui', '', $class);

		set_include_path(get_include_path() . PS . APPROOT);
		spl_autoload_extensions('.php');
		spl_autoload($class);
	}

	/**
	 * 自动加载模型类
	 * @param  string $class 类名
	 * @return void
	 */
	public function model($class) {
		$class = preg_replace('/Model$/ui', '', $class);

		set_include_path(get_include_path() . PS . MODROOT);
		spl_autoload_extensions('.php');
		spl_autoload($class);
	}

	/**
	 * 自动加载系统库类
	 * @param  string $class 类名
	 * @return void
	 */
	public function library($class) {
		$class = camelToSnake($class);

		set_include_path(get_include_path() . PS . LIBROOT);
		spl_autoload_extensions('.php');
		spl_autoload($class);
	}

}