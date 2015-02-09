<?php

/**
 * 路由类
 */
class Route {

	/**
	 * 路由信息
	 * @var array
	 */
	protected static $routes = array();

	/**
	 * 添加路由信息
	 * @param string $url    请求URL
	 * @param string $action 触发动作
	 */
	public static function add($url, $action) {
		self::$routes[$url] = $action;
	}

	/**
	 * 解析路由信息
	 * @param  string $url 请求URL
	 * @return array      解析后的路由信息
	 */
	public static function parse($url) {
		$urls        = explode('/', $url);
		$controller  = array_shift($urls);
		$action      = array_shift($urls);
		$queryString = sanitize($urls);

		$route = $controller . '/' . $action;
		if (isset(self::$routes[$route])) {
			list($controller, $action) = explode('.', self::$routes[$route]);
		}

		return array($controller, $action, $queryString);
	}

	/**
	 * 分发路由信息
	 * @param  string $url 请求URL
	 * @return [type] [description]
	 */
	public static function dispatch($url) {
		$uri = explode('/', trim($url, '/'));
		
	}

}