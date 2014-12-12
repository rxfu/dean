<?php

/**
 * 应用程序类
 */
class App extends Prefab {

	/**
	 * 程序版本号
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * 运行网站系统
	 * @return NULL
	 */
	public function run() {
		$this->setReporting();
		set_error_handler('self::error', E_USER_ERROR);
		Session::start();

		if (isset($_GET['url'])) {
			$this->call($_GET['url']);
		} else {
			$this->call();
		}
	}

	/**
	 * 输出错误信息
	 * @param  string $code    错误代码
	 * @param  string $message 错误信息
	 * @return NULL
	 */
	public static function error($code, $message = '') {
		echo '<b>ERROR</b>: [' . $code . '] ' . $message;
	}

	/**
	 * 计算字符串散列值
	 * @param  string $string 字符串
	 * @return string         散列值
	 */
	public function hash($string) {
		return hash('sha1', $string);
	}

	/**
	 * 页面重定向
	 * @param  string $url URL地址
	 * @return NULL
	 */
	public function redirect($url) {
		header('Location: ' . $url);
	}

	/**
	 * 获取当前域名
	 * @return string 当前域名
	 */
	public function getDomain() {
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

	/**
	 * 获取网站URL地址
	 * @return string 网站URL地址
	 */
	public function getBaseUrl() {
		return getDomain() . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/') + 1);
	}

	/**
	 * 获取网站当前页面
	 *
	 * @return string 当前页面名称
	 */
	public function getCurrentPage() {
		return substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/'));
	}

	/**
	 * 获得客户端真实IP地址
	 *
	 * @return string 客户端真实IP地址
	 */
	public function getClientIp() {
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

	/**
	 * 设置调试状态下错误报告模式
	 */
	public function setReporting() {
		if (DEBUG) {
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');
		} else {
			error_reporting(E_ALL);
			ini_set('display_errors', 'Off');
			ini_set('log_errors', 'On');
			ini_set('error_log', LOGROOT . DS . 'error.log');
		}
	}

	/**
	 * 请求执行控制器中方法
	 * @param  string $url 请求URL
	 * @return NULL
	 */
	public function call($url = NULL) {
		$url                                     = is_null($url) ? '/' : $url;
		list($controller, $action, $queryString) = Route::parse($url);
		$controller                              = ucwords($controller) . 'Controller';
		$dispatch                                = new $controller;
		if (true == method_exists($dispatch, $action)) {
			call_user_func_array(array($dispatch, $action), $queryString);
		} else {
			throw new RuntimeException('方法 ' . $action . ' 在类 ' . $controller . ' 中不存在');
		}
	}

	/**
	 * 从数组中去除转义反斜线
	 * @param  string|array $value 转义数组
	 * @return string|array        去除转移反斜线后的数组
	 */
	public function stripSlashesDeep($value) {
		return is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	}

}