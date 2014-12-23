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

if (!function_exists('isPost')) {

	/**
	 * 判断是否POST方法
	 * @return boolean 是为TRUE，否为FALSE
	 */
	function isPost() {
		return 'POST' === $_SERVER['REQUEST_METHOD'];
	}
}

if (!function_exists('route')) {

	/**
	 * 生成路由信息地址
	 * @return string 路由信息地址，生成失败为NULL
	 */
	function route() {
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

			return $route . $param;
		}

		return NULL;
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
