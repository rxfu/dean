<?php

/**
 * 常用函数
 */

if (!function_exists('error')) {

	/**
	 * 输出错误信息
	 * @param  string $code    错误代码
	 * @param  string $message 错误信息
	 * @return NULL
	 */
	function error($code, $message, $file, $line) {
		switch ($code) {
			case E_USER_ERROR:
				echo '<b>ERROR</b>: [' . $code . '] ' . $message . '<br />\n';
				echo '  Fatal error on line ' . $line . ' in file ' . $file;
				echo ', PHP ' . PHP_VERSION . ' (' . PHP_OS . ')<br />\n';
				echo 'Aborting...<br />\n';
				exit(1);
				break;

			case E_USER_WARNING:
				echo '<b>WARNING</b>: [' . $code . '] ' . $message . '<br />\n';
				break;

			case E_USER_NOTICE:
				echo '<b>NOTICE</b>: [' . $code . '] ' . $message . '<br />\n';
				break;

			default:
				echo '<b>UNKNOWN</b>: [' . $code . '] ' . $message . '<br />\n';
				break;
		}
	}
}

if (!function_exists('getBaseUrl')) {

	/**
	 * 获取网站URL地址
	 * @return string 网站URL地址
	 */
	function getBaseUrl() {
		return getDomain() . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/') + 1);
	}
}

if (!function_exists('getClientIp')) {

	/**
	 * 获得客户端真实IP地址
	 *
	 * @return string 客户端真实IP地址
	 */
	function getClientIp() {
		$ip = '';

		if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}

		//获取代理IP
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

			if ($ip) {
				$ips = array_unshift($ips, $ip);
			}

			$count = count($ips);
			for ($i = 0; $i < $count; $i++) {
				//排除局域网ip
				if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])) {
					$ip = $ips[$i];
					break;
				}
			}
		}

		return empty($_SERVER['REMOTE_ADDR']) ? $ip : $_SERVER['REMOTE_ADDR'];
	}
}

if (!function_exists('getCurrentPage')) {

	/**
	 * 获取网站当前页面
	 *
	 * @return string 当前页面名称
	 */
	function getCurrentPage() {
		return substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/'));
	}
}

if (!function_exists('getDomain')) {

	/**
	 * 获取当前域名
	 * @return string 当前域名
	 */
	function getDomain() {
		$protocol = (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';

		if (isset($_SERVER['HTTP_X_FORWORD_HOST'])) {
			$host = $_SERVER['HTTP_X_FORWORD_HOST'];
		} elseif (isset($_SERVER['HTTP_HOST'])) {
			$host = $_SERVER['HTTP_HOST'];
		} else {
			if (isset($_SERVER['SERVER_PORT'])) {
				$port = ':' . $_SERVER['SERVER_PORT'];

				if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol)) {
					$port = '';
				}
			} else {
				$port = '';
			}

			if (isset($_SERVER['SERVER_NAME'])) {
				$host = $_SERVER['SERVER_NAME'] . $port;
			} elseif (isset($_SERVER['SERVER_ADDR'])) {
				$host = $_SERVER['SERVER_ADDR'] . $port;
			}
		}

		return $protocol . $host;
	}
}

if (!function_exists('hashString')) {

	/**
	 * 计算字符串散列值
	 * @param  string $string 字符串
	 * @return string         散列值
	 */
	function hashString($string) {
		return hash('sha1', $string);
	}
}

if (!function_exists('redirect')) {

	/**
	 * 页面重定向
	 * @param  string $url URL地址
	 * @return NULL
	 */
	function redirect($url) {
		header('Location: ' . $url);
	}
}

if (!function_exists('route')) {

	/**
	 * 请求执行控制器中方法
	 * @param  string $url 请求url方法
	 * @return NULL
	 */
	function route($url) {
		$url                                     = is_null($url) ? '/' : $url;
		list($controller, $action, $queryString) = Route::parse($url);
		$controller                              = ucwords($controller) . 'Controller';
		$dispatch                                = new $controller;
		if (method_exists($dispatch, $action)) {
			call_user_func_array(array($dispatch, $action), $queryString);
		} else {
			trigger_error('方法 ' . $action . ' 在类 ' . $controller . ' 中不存在', E_USER_ERROR);
		}
	}
}

if (!function_exists('sanitize')) {

	/**
	 * 清理输入变量
	 * @param  array|string $value 转义变量
	 * @return array|string        转移后变量
	 */
	function sanitize($value) {
		return is_array($value) ? array_map('sanitize', $value) : trim(htmlentities(strip_tags($value)));
	}
}