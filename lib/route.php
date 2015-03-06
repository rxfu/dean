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
	 * 生成路由信息地址
	 * @return string 路由信息地址，生成失败为NULL
	 */
	public static function to() {
		if (0 == func_num_args()) {
			return '/';
		}

		if (1 <= func_num_args()) {
			$args  = func_get_args();
			$route = array_shift($args);
			$route = str_replace('.', '/', $route);

			$param = '';
			if (!empty($args)) {
				foreach ($args as $index => $value) {
					if (is_array($args[$index])) {
						$args[$index] = implode('/', $args[$index]);
					}
				}
				$param = '/' . implode('/', $args);
			}

			return getBaseUrl() . $route . $param;
		}

		return null;
	}

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

		$controller = isset(self::$_routes[0]) && !isEmpty(self::$_routes[0]) ? self::$_routes[0] : Config::get('route.default_controller');
		$method     = isset(self::$_routes[1]) && !isEmpty(self::$_routes[1]) ? self::$_routes[1] : Config::get('route.default_method');
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