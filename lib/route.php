<?php

/**
 * 路由类
 */
class Route {

	/**
	 * 当前路由
	 * @var array
	 */
	private $_routes = null;

	/**
	 * 分发路由信息
	 * @return void
	 */
	public static function dispatch() {
		$this->_getUrl();

		$controller = '' !== $uri && isset($this->_routes[0]) ? $this->_routes[0] : DEFAULT_CONTROLLER;
		$method     = '' !== $uri && isset($this->_routes[1]) ? $this->_routes[1] : DEFAULT_METHOD;
		$args       = is_array($this->_routes) && count($this->_routes) > 2 ? array_slice($this->_routes, 2) : array();

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

	/**
	 * 获取URL路径信息
	 * @return void
	 */
	private function _getUrl() {
		parse_str($_SERVER['QUERY_STRING']);
		$url           = isset($url) ? $url : null;
		$url           = trim($url, ' /');
		$url           = filter_var($url, FILTER_SANITIZE_URL);
		$this->_routes = explode('/', $url);
	}

}