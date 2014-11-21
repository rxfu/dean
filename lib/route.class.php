<?php

/**
 * 路由类
 */
class Route extends Prefab {

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
		$urls = explode('/', $url, 3);

		$key = $urls[0] . '/' . $urls[1];
		if (isset(self::$routes[$key])) {
			$value  = self::$routes[$key];
			$values = explode('.', $value);

			return array($values, $values, $urls[2]);
		} else {
			return array($urls[0], $urls[1], $urls[2]);
		}
	}
}