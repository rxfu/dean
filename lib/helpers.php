<?php

/**
 * 常用函数
 */

if (!function_exists('css')) {

	/**
	 * 获取CSS文件网站路径
	 * @param  string $file CSS文件
	 * @return string       CSS文件网站路径
	 */
	function css($file) {
		return getBaseUrl() . $file;
	}
}

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
				echo '<b>ERROR</b>: [' . $code . '] ' . $message . '<br />' . PHP_EOL;
				echo '  Fatal error on line ' . $line . ' in file ' . $file;
				echo ', PHP ' . PHP_VERSION . ' (' . PHP_OS . ')<br />' . PHP_EOL;
				echo 'Aborting...<br />' . PHP_EOL;
				exit(1);
				break;

			case E_USER_WARNING:
				echo '<b>WARNING</b>: [' . $code . '] ' . $message . '<br />' . PHP_EOL;
				break;

			case E_USER_NOTICE:
				echo '<b>NOTICE</b>: [' . $code . '] ' . $message . '<br />' . PHP_EOL;
				break;

			default:
				echo '<b>UNKNOWN</b>: [' . $code . '] ' . $message . '<br />' . PHP_EOL;
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
		return getDomain() . '/' . VD . '/';
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
		$encrypt = AUTH_SALT . $string;
		return hash('sha1', $encrypt);
	}
}

if (!function_exists('js')) {

	/**
	 * 获取JavaScript文件网站路径
	 * @param  string $file JavaScript文件
	 * @return string       JavaScript文件网站路径
	 */
	function js($file) {
		return '<script src="' . getBaseUrl() . $file . '"></script>';
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

if (!function_exists('toLink')) {

	/**
	 * 生成路由信息地址
	 * @return string 路由信息地址，生成失败为NULL
	 */
	function toLink() {
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

		return NULL;
	}
}

if (!function_exists('parseTerm')) {

	/**
	 * 解析年度、学期代码
	 *
	 * @param string  $term 年度学期号
	 * @return array 年度学期值
	 */
	function parseTerm($term) {
		$data = null;
		if (is_numeric($term)) {
			$data['year'] = substr($term, 0, 4);
			$data['term'] = substr($term, 4, 1);
		}

		return $data;
	}
}

if (!function_exists('parseType')) {
	
	/**
	 * 解析选课日志操作类型
	 *
	 * @param string  $type 操作类型
	 * @return string       操作类型名称
	 */
	function parseType($type) {
		switch (trim($type)) {
			case 'LOGIN':
				return '登录系统';
			case 'LOGOUT':
				return '登出系统';
			case 'CHGPWD':
				return '修改密码';
			case 'INSERT':
				return '选课';
			case 'DELETE':
				return '退课';
			case 'REGIST':
				return '考试报名';
			case 'APPLY':
				return '教室申请';
			default:
				return '未知类型';
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

if (!function_exists('section')) {

	/**
	 * 包含PHP片段
	 * @param  string $section PHP片段
	 * @return NULL
	 */
	function section($section) {
		$path = str_replace('.', '/', $section);
		$path = WEBROOT . DS . $path . '.php';

		include $path;
	}
}
