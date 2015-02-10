<?php

/**
 * 路由类
 */
class Route {

	/**
	 * 分发路由信息
	 * @return void
	 */
	public static function dispatch() {
		parse_str($_SERVER['QUERY_STRING']);
		$url   = isset($url) ? $url : '/';
		$uri   = trim($url, ' /');
		$parts = explode('/', $uri);

		$controller = '' !== $uri && isset($parts[0]) ? $parts[0] : DEFAULT_CONTROLLER;
		$method     = '' !== $uri && isset($parts[1]) ? $parts[1] : DEFAULT_METHOD;
		$args       = is_array($parts) && count($parts) > 2 ? array_slice($parts, 2) : array();

		$controller = snakeToCamel($controller) . 'Controller';
		if (!file_exists(APPROOT . DS . $controller . '.php')) {
			trigger_error('类文件' . $controller . '.php 不存在');
			return;
		}
		$dispatch = new $controller;

		if (method_exists($dispatch, $method)) {
			call_user_func_array(array($dispatch, $method), $args);
		} else {
			trigger_error('方法 ' . $method . ' 在类 ' . $controller . ' 中不存在');
			return;
		}
	}

}