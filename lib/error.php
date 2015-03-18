<?php

/**
 * 错误处理类
 */
class Error {

	use Singleton;

	/**
	 * 错误视图对象
	 * @var View
	 */
	private static $_view = null;

	/**
	 * 构造方法
	 */
	public function __construct() {
		self::$_view = new View();
	}

	public static function display($message) {
		return self::$_view->display('error.index', array('message' => $message));
	}

}