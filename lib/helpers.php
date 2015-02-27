<?php

/**
 * 常用函数
 */

if (!function_exists('array_column')) {

	/**
	 * Returns the values from a single column of the input array, identified by
	 * the $columnKey.
	 *
	 * Optionally, you may provide an $indexKey to index the values in the returned
	 * array by the values from the $indexKey column in the input array.
	 *
	 * @param array $input A multi-dimensional array (record set) from which to pull
	 *                     a column of values.
	 * @param mixed $columnKey The column of values to return. This value may be the
	 *                         integer key of the column you wish to retrieve, or it
	 *                         may be the string key name for an associative array.
	 * @param mixed $indexKey (Optional.) The column to use as the index/keys for
	 *                        the returned array. This value may be the integer key
	 *                        of the column, or it may be the string key name.
	 * @return array
	 */
	function array_column($input = null, $columnKey = null, $indexKey = null) {
		// Using func_get_args() in order to check for proper number of
		// parameters and trigger errors exactly as the built-in array_column()
		// does in PHP 5.5.
		$argc   = func_num_args();
		$params = func_get_args();
		if ($argc < 2) {
			trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
			return null;
		}
		if (!is_array($params[0])) {
			trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
			return null;
		}
		if (!is_int($params[1])
			&& !is_float($params[1])
			&& !is_string($params[1])
			&& $params[1] !== null
			&& !(is_object($params[1]) && method_exists($params[1], '__toString'))
		) {
			trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		if (isset($params[2])
			&& !is_int($params[2])
			&& !is_float($params[2])
			&& !is_string($params[2])
			&& !(is_object($params[2]) && method_exists($params[2], '__toString'))
		) {
			trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
			return false;
		}
		$paramsInput     = $params[0];
		$paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
		$paramsIndexKey  = null;
		if (isset($params[2])) {
			if (is_float($params[2]) || is_int($params[2])) {
				$paramsIndexKey = (int) $params[2];
			} else {
				$paramsIndexKey = (string) $params[2];
			}
		}
		$resultArray = array();
		foreach ($paramsInput as $row) {
			$key    = $value    = null;
			$keySet = $valueSet = false;
			if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
				$keySet = true;
				$key    = (string) $row[$paramsIndexKey];
			}
			if ($paramsColumnKey === null) {
				$valueSet = true;
				$value    = $row;
			} elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
				$valueSet = true;
				$value    = $row[$paramsColumnKey];
			}
			if ($valueSet) {
				if ($keySet) {
					$resultArray[$key] = $value;
				} else {
					$resultArray[] = $value;
				}
			}
		}
		return $resultArray;
	}
}

if (!function_exists('array_remove')) {

	/**
	 * 根据给定值删除数组元素
	 * @param  array $haystack 给定数组
	 * @param  mixed $needle   给定值
	 * @return array           删除元素后数组
	 */
	function array_remove($haystack, $needle) {
		if (false !== ($key = array_search($needle, $haystack))) {
			unset($haystack[$key]);
		}

		return $haystack;
	}
}

if (!function_exists('array_to_field')) {

	/**
	 * 数组转换成字段名格式
	 * @param  array $array 字段数组
	 * @return string        逗点格式字段名序列
	 */
	function array_to_field($array) {
		return implode(',', $array);
	}
}

if (!function_exists('array_to_pg')) {

	/**
	 * PHP数组转换成PostgreSQL数组
	 * @param  array $array 转换数组
	 * @return string        转换后数组格式
	 */
	function array_to_pg($array) {
		$array = is_array($array) ? $array : array($array);
		return '{' . implode(',', $array) . '}';
	}
}

if (!function_exists('between')) {

	/**
	 * 测试输入值是否在开始值和结束值之间
	 * @param  integer $value 输入值
	 * @param  integer $start 开始值
	 * @param  integer $end   结束值
	 * @return boolean        在开始值和结束值之间为TRUE，否则为FALSE
	 */
	function between($value, $start, $end) {
		return $value >= $start && $value <= $end;
	}
}

if (!function_exists('camelToSnake')) {

	/**
	 * 转换camel到snake
	 * @param  string $text camel字符串
	 * @return string       snake字符串
	 */
	function camelToSnake($text) {
		$text = preg_replace('/[A-Z]/', '_\0', $text);
		$text = strtolower($text);

		return ltrim($text, '_');
	}
}

if (!function_exists('css')) {

	/**
	 * 获取CSS文件网站路径
	 * @param  string $file CSS文件
	 * @return string       CSS文件网站路径
	 */
	function css($file) {
		return '<link rel="stylesheet" href="' . getBaseUrl() . $file . '">' . PHP_EOL;
	}
}

if (!function_exists('encrypt')) {

	/**
	 * 加密字符串
	 * @param  string $string 字符串
	 * @return string         加密字符串
	 */
	function encrypt($string) {
		/*
		$encrypt = AUTH_SALT . $string;
		return hash('sha1', $encrypt);
		 */
		return $string;
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
		if (!headers_sent()) {
			header('Content-Type:text/html; charset=utf-8');
		}
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

if (!function_exists('gpa')) {

	/**
	 * 计算成绩平均绩点
	 * @param  double $score 学生成绩
	 * @return double        学生绩点
	 */
	function gpa($score) {
		return PASSLINE <= $score ? ($score / 10 - 5) : 0;
	}
}

if (!function_exists('img')) {

	/**
	 * 获取图像文件网站路径
	 * @param  string $file 图像文件
	 * @return string       图像文件网站路径
	 */
	function img($file) {
		return getBaseUrl() . $file;
	}
}

if (!function_exists('isAjax')) {

	/**
	 * 判断是否AJAX提交
	 * @return boolean 是为TRUE，否为FALSE
	 */
	function isAjax() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
}

if (!function_exists('isAlphaNumber')) {

	/**
	 * 判断字符串是否由字母和数字组成
	 * @param  string  $text 字符串
	 * @return boolean       是为TRUE，否为FAlSE
	 */
	function isAlphaNumber($text) {
		return ctype_alnum($text);
	}
}

if (!function_exists('isEmpty')) {

	/**
	 * 判断字符串是否为空或空白
	 * @param  string  $text 字符串
	 * @return boolean       空或空白为TRUE，非空或非空白为FALSE
	 */
	function isEmpty($text) {
		return empty($text) ? true : ctype_space($text);
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

if (!function_exists('js')) {

	/**
	 * 获取JavaScript文件网站路径
	 * @param  string $file JavaScript文件
	 * @return string       JavaScript文件网站路径
	 */
	function js($file) {
		return '<script src="' . getBaseUrl() . $file . '"></script>' . PHP_EOL;
	}
}

if (!function_exists('parseCourse')) {

	/**
	 * 获取课程号
	 * @param  string $cno 课程序号
	 * @return string      课程号
	 */
	function parseCourse($cno) {
		return substr($cno, 2, 8);
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
				return '重修申请';
			default:
				return '未知类型';
		}
	}
}

if (!function_exists('redirect')) {

	/**
	 * 重定向页面
	 * @param  string $url 重定向URL
	 * @param  array $params 重定向参数
	 * @return void
	 */
	function redirect($url, $params = null) {
		$url = strtr($url, '.', '/') . '/';

		if (isEmpty($params)) {
			header('Location: ' . getBaseUrl() . $url);
		} elseif (is_array($params)) {
			header('Location: ' . getBaseUrl() . $url . implode('/', $params));
		} elseif (is_string($params)) {
			header('Location: ' . getBaseUrl() . $url . $params);
		}

		exit(0);
	}
}

if (!function_exists('sanitize')) {

	/**
	 * 清理输入变量
	 * @param  array|string $value 转义变量
	 * @return array|string        转义后变量
	 */
	function sanitize($value) {
		return is_array($value) ? array_map('sanitize', $value) : trim(htmlentities(strip_tags($value)));
	}
}

if (!function_exists('section')) {

	/**
	 * 包含PHP片段
	 * @param  string $section PHP片段
	 * @return mixed
	 */
	function section($section) {
		$path = strtr($section, '.', '/');
		$path = WEBROOT . DS . $path . '.php';

		include $path;
	}
}

if (!function_exists('snakeToCamel')) {

	/**
	 * 转换snake到camel
	 * @param  string $text snake字符串
	 * @return string       camel字符串
	 */
	function snakeToCamel($text) {
		$text = strtr($text, '_', ' ');
		$text = ucwords($text);

		return str_replace(' ', '', $text);
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

if (!function_exists('weekend')) {

	/**
	 * 星期名称
	 * @param  integer $week 星期
	 * @return string       星期名
	 */
	function weekend($week) {
		switch ($week) {
			case 1:
				return '一';
			case 2:
				return '二';
			case 3:
				return '三';
			case 4:
				return '四';
			case 5:
				return '五';
			case 6:
				return '六';
			case 7:
				return '日';
		}
	}
}
