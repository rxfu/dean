<?php

/**
 * 页面重定向类
 */
class Redirect {

	/**
	 * 重定向地址
	 * @var string
	 */
	private static $route = null;

	/**
	 * 视图对象
	 * @var object
	 */
	protected $view = null;

	/**
	 * 重定向到URL地址
	 * @param  string $url URL地址
	 * @return NULL
	 */
	public static function to($url) {
		self::$route = str_replace('.', '/', $url);
		header('Location:' . getBaseUrl() . self::$route);
	}

	public static function route($route) {

	}
}