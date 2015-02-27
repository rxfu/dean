<?php

/**
 * 路由类
 */
class Route {

	/**
	 * 当前路由
	 * @var array
	 */
	private static $_routes = null;

	/**
	 * 分发路由信息
	 * @return void
	 */
	public static function dispatch() {
		parse_str($_SERVER['QUERY_STRING']);
		$url           = isset($url) ? $url : null;
		$url           = trim($url, ' /');
		$url           = filter_var($url, FILTER_SANITIZE_URL);
		self::$_routes = explode('/', $url);

		$controller = isset(self::$_routes[0]) && !isEmpty(self::$_routes[0]) ? self::$_routes[0] : DEFAULT_CONTROLLER;
		$method     = isset(self::$_routes[1]) && !isEmpty(self::$_routes[1]) ? self::$_routes[1] : DEFAULT_METHOD;
		$args       = is_array(self::$_routes) && count(self::$_routes) > 2 ? array_slice(self::$_routes, 2) : array();

		$dispatcher = snakeToCamel($controller) . 'Controller';
		if (!file_exists(APPROOT . DS . $dispatcher . '.php')) {
			trigger_error('类文件' . $dispatcher . '.php 不存在');
			return;
		}
		$dispatch = new $dispatcher;
		$dispatch->loadModel($controller);

		if (method_exists($dispatch, $method)) {
			call_user_func_array(array($dispatch, $method), $args);
		} else {
			trigger_error('方法 ' . $method . ' 在类 ' . $dispatcher . ' 中不存在');
			return;
		}
	}

}