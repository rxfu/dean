<?php

/**
 * 注册类
 */
final class Registry {

	/**
	 * 对象列表
	 * @var array
	 */
	private static $table;

	/**
	 * 对象是否已经存在
	 * @param  string $key 对象名称
	 * @return bool      存在返回TRUE，不存在返回FALSE
	 */
	public static function exists($key) {
		return isset(self::$table[$key]);
	}

	/**
	 * 添加对象到列表
	 * @param string $key 对象名称
	 * @param object $obj 对象实例
	 */
	public static function set($key, $obj) {
		return self::$table[$key] = $obj;
	}

	/**
	 * 从列表中获取对象
	 * @param  string $key 对象名称
	 * @return object      对象实例
	 */
	public static function get($key) {
		return self::$table[$key];
	}

	/**
	 * 从列表中删除对象
	 * @param  string $key 对象名称
	 * @return object      对象实例
	 */
	public static function clear($key) {
		self::$table[$key] = NULL;
		unset(self::$table[$key]);
	}

	/**
	 * 阻止__clone()方法
	 * @return NULL
	 */
	private function __clone() {}

	/**
	 * 阻止__construct()方法
	 */
	private function __construct() {}
}

/**
 * 预制类，工厂模式创建单一实例对象
 */
abstract class Prefab {

	/**
	 * 生成对象唯一实例
	 * @return object 对象实例
	 */
	public static function instance() {
		if (!Registry::exists($class = get_called_class())) {
			$ref  = new ReflectionClass($class);
			$args = func_get_args();
			Registry::set($class, $args ? $ref->newInstanceArgs($args) : new $class);
		}
		return Registry::get($class);
	}
}

/**
 * 基础类，扩展自Prefab类
 */
class Base extends Prefab {

	/**
	 * HTTP 状态代码 (RFC 2616)
	 */
	const
	HTTP_100 = 'Continue',
	HTTP_101 = 'Switching Protocols',
	HTTP_200 = 'OK',
	HTTP_201 = 'Created',
	HTTP_202 = 'Accepted',
	HTTP_203 = 'Non-Authorative Information',
	HTTP_204 = 'No Content',
	HTTP_205 = 'Reset Content',
	HTTP_206 = 'Partial Content',
	HTTP_300 = 'Multiple Choices',
	HTTP_301 = 'Moved Permanently',
	HTTP_302 = 'Found',
	HTTP_303 = 'See Other',
	HTTP_304 = 'Not Modified',
	HTTP_305 = 'Use Proxy',
	HTTP_307 = 'Temporary Redirect',
	HTTP_400 = 'Bad Request',
	HTTP_401 = 'Unauthorized',
	HTTP_402 = 'Payment Required',
	HTTP_403 = 'Forbidden',
	HTTP_404 = 'Not Found',
	HTTP_405 = 'Method Not Allowed',
	HTTP_406 = 'Not Acceptable',
	HTTP_407 = 'Proxy Authentication Required',
	HTTP_408 = 'Request Timeout',
	HTTP_409 = 'Conflict',
	HTTP_410 = 'Gone',
	HTTP_411 = 'Length Required',
	HTTP_412 = 'Precondition Failed',
	HTTP_413 = 'Request Entity Too Large',
	HTTP_414 = 'Request-URI Too Long',
	HTTP_415 = 'Unsupported Media Type',
	HTTP_416 = 'Requested Range Not Satisfiable',
	HTTP_417 = 'Expectation Failed',
	HTTP_500 = 'Internal Server Error',
	HTTP_501 = 'Not Implemented',
	HTTP_502 = 'Bad Gateway',
	HTTP_503 = 'Service Unavailable',
	HTTP_504 = 'Gateway Timeout',
	HTTP_505 = 'HTTP Version Not Supported';

	/**
	 * 错误消息
	 */
	const
	E_PATTERN = '无效路由模式: %s',
	E_Named   = '命名路由不存在: %s',
	E_Fatal   = '严重错误: %s',
	E_Open    = '不能打开 %s',
	E_Routes  = '未指定路由',
	E_Class   = '无效类 %s',
	E_Method  = '无效方法 %s',
	E_Hive    = '无效全局变量 %s';

	/**
	 * 全局变量
	 * @var string
	 */
	private $hive;

	/**
	 * 初始化设置
	 * @var string
	 */
	private $init;

	/**
	 * 语言序列
	 * @var string
	 */
	private $languages;

	/**
	 * 默认显示语言
	 * @var string
	 */
	private $fallback = 'en';

	/**
	 * 同步PHP全局变量到类hive变量
	 * @param  string $key 全局变量名
	 * @return array      全局变量数组
	 */
	public function sync($key) {
		return $this->hive[$key] = $GLOBALS['_' . $key];
	}

	/**
	 * 拆分指定全局变量
	 * @param  string $key 全局变量名
	 * @return array      全局变量拆分后数组
	 */
	private function cut($key) {
		return preg_split('/\[\h*[\'"]?(.+?)[\'"]?\h*\]|(->)|\./',
			$key, NULL, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
	}

	/**
	 * 用当前指定路由替换URL
	 * @param  string $url URL
	 * @return array|string      URL对应路由值
	 */
	public function build($url) {
		if (is_array($url)) {
			foreach ($url as &$var) {
				$var = $this->build($var);
				unset($var);
			}
		} elseif (preg_match_all('/@(\w+)/', $url, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				if (array_key_exists($match[1], $this->hive['PARAMS'])) {
					$url = str_replace($match[0],
						$this->hive['PARAMS'][$match[1]], $url);
				}
			}
		}

		return $url;
	}

	/**
	 * 生成64位/base36 hash值
	 * @param  string $str 待散列字符串
	 * @return string      hash值
	 */
	public function hash($str) {
		return str_pad(base_convert(hexdec(substr(sha1($str), -16)), 10, 36), 11, '0', STR_PAD_LEFT);
	}

	/**
	 * 查找IP地址是否在黑名单中
	 * @param  string $ip IP地址
	 * @return bool     TRUE在黑名单中，FALSE不在黑名单中
	 */
	public function blacklisted($ip) {
		if ($this->hive['DNSBL'] && !in_array($ip, is_array($this->hive['EXEMPT']) ? $this->hive['EXEMPT'] : $this->split($this->hive['EXEMPT']))) {
			// 转换IPv4地址
			$rev = implode('.', array_reverse(explode('.', $ip)));
			foreach (is_array($this->hive['DNSBL']) ? $this->hive['DNSBL'] : $this->split($this->hive['DNSBL']) as $server) {
				// 查找DNS
				if (checkdnsrr($rev . '.' . $server, 'A')) {
					return TRUE;
				}
			}
		}

		return FALSE;
	}

	/**
	 * 发送HTTP/1.1状态头部信息
	 * @param  int $code 错误代码
	 * @return string       错误描述
	 */
	public function status($code) {
		$reason = constant('self::HTTP_' . $code);
		if (PHP_SAPI != 'cli') {
			header('HTTP/1.1' . $code . ' ' . $reason);
		}

		return $reason;
	}

	/**
	 * 记录系统错误
	 * @param  int $code  错误代码
	 * @param  string $text  错误信息
	 * @param  array $trace 调试信息
	 * @return NULL
	 */
	public function error($code, $text = '', array $trace = NULL) {
		$prior  = $this->hive['ERROR'];
		$header = $this->status($code);
		$req    = $this->hive['VERB'] . ' ' . $this->hive['PATH'];

		if (!$text) {
			$text = 'HTTP ' . $code . ' (' . $req . ')';
		}
		error_log($text);

		if (!$trace) {
			$trace = array_slice(debug_backtrace(FALSE), 1);
		}

		$this->hive['ERROR'] = array(
			'status' => $header,
			'code'   => $code,
			'text'   => $text,
			'trace'  => $trace,
		);

		$eol                   = '\n';
		$handle                = $this->hive['ONERROR'];
		$this->hive['ONERROR'] = NULL;
		if ((!$handler || $this->call($handler, $this, 'beforeroute,afterroute') === FALSE) && !$prior && PHP_SAPI != 'cli' && !$this->hive['QUIET']) {
			echo $this->hive['AJAX'] ? json_encode($this->hive['ERROR']) :
			('<!DOCTYPE html>' . $eol .
				'<html>' . $eol .
				'<head>' .
				'<title>' . $code . ' ' . $header . '</title>' .
				'</head>' . $eol .
				'<body>' . $eol .
				'<h1>' . $header . '</h1>' . $eol .
				'<p>' . $this->encode($text ?: $req) . '</p>' . $eol .
				'</body>' . $eol .
				'</html>');
			if ($this->hive['HALT']) {
				die;
			}
		}
	}

	/**
	 * 执行框架程序
	 * @return NULL
	 */
	public function run() {
		// 检测IP地址黑名单
		if ($this->blacklisted($this->hive['IP'])) {
			$this->error(403);
		}

		// 检测是否定义路由
		if (!$this->hive['ROUTES']) {
			user_error(self::E_ROUTES);
		}

		// 匹配第一条路由
		krsort($this->hive['ROUTES']);
		// 转换为基于BASE的URL
		$req     = preg_replace('/^' . preg_quote($this->hive['BASE'], '/') . '(\/.*|$)/', '\1', $this->hive['URI']);
		$allowed = array();
		$case    = $this->hive['CASELESS'] ? 'i' : '';
		foreach ($this->hive['ROUTES'] as $url => $routes) {
			$url = str_replace("\x00" . '@', '@', $url);
			if (!preg_match('/^' . preg_replace('/@(\w+\b)/', '(?P<\1>[^\/\?]+)', str_replace('\*', '([^\?]*)', preg_quote($url, '/'))) . '\/?(?:\?.*)?$/' . $case . 'um', $req, $args)) {
				continue;
			}

			$route = NULL;
			if (isset($routes[$this->hive['AJAX']+1])) {
				$route = $routes[$this->hive['AJAX']+1];
			} elseif (isset($routes[self::REQ_SYNC|self::REQ_AJAX])) {
				$route = $routes[self::REQ_SYNC|self::REQ_AJAX];
			}

			if (!$route) {
				continue;
			}

			if ($this->hive['VERB'] != 'OPTIONS' &&
				isset($route[$this->hive['VERB']])) {
				$parts = parse_url($req);
				if ($this->hive['VERB'] == 'GET' &&
					preg_match('/.+\/$/', $parts['path'])) {
					$this->reroute(substr($parts['path'], 0, -1) .
						(isset($parts['query']) ? ('?' . $parts['query']) : ''));
				}

				list($handler, $ttl, $kbps) = $route[$this->hive['VERB']];
				if (is_bool(strpos($url, '/*'))) {
					foreach (array_keys($args) as $key) {
						if (is_numeric($key) && $key) {
							unset($args[$key]);
						}
					}
				}

				if (is_string($handler)) {
					// 替换路由模式
					$handler = preg_replace_callback('/@(\w+\b)/',
						function ($id) use ($args) {
							return isset($args[$id[1]]) ? $args[$id[1]] : $id[0];
						},
						$handler
					);
					if (preg_match('/(.+)\h*(?:->|::)/', $handler, $match) &&
						!class_exists($match[1])) {
						$this->error(404);
					}
				}

				// 获取路由模式参数
				$this->hive['PARAMS'] = $args = array_map('urldecode', $args);
				// 保存匹配路由模式
				$this->hive['PATTERN'] = $url;
				// P执行请求
				$body = '';
				$now  = microtime(TRUE);
				if (preg_match('/GET|HEAD/', $this->hive['VERB']) &&
					isset($ttl)) {
					// 只有GET和HEAD请求可以被响应
					$headers = $this->hive['HEADERS'];
					$cache   = Cache::instance();
					$cached  = $cache->exists(
						$hash = $this->hash($this->hive['VERB'] . ' ' .
							$this->hive['URI']) . '.url', $data);
					if ($cached && $cached[0]+$ttl > $now) {
						// 从后台缓存获取数据
						list($headers, $body) = $data;
						if (PHP_SAPI != 'cli') {
							array_walk($headers, 'header');
						}

						$this->expire($cached[0]+$ttl - $now);
					} else {
						// HTTP客户端cache页面超时
						$this->expire($ttl);
					}
				} else {
					$this->expire(0);
				}

				if (!strlen($body)) {
					if (!$this->hive['RAW'] && !$this->hive['BODY']) {
						$this->hive['BODY'] = file_get_contents('php://input');
					}

					ob_start();
					// 执行路由处理程序
					$this->call($handler, array($this, $args),
						'beforeroute,afterroute');
					$body = ob_get_clean();
					if ($ttl && !error_get_last())
					// 保存到后台缓存
					{
						$cache->set($hash, array(headers_list(), $body), $ttl);
					}
				}

				$this->hive['RESPONSE'] = $body;
				if (!$this->hive['QUIET']) {
					if ($kbps) {
						$ctr = 0;
						foreach (str_split($body, 1024) as $part) {
							// 输出
							$ctr++;
							if ($ctr / $kbps > ($elapsed = microtime(TRUE) - $now) &&
								!connection_aborted()) {
								usleep(1e6 * ($ctr / $kbps - $elapsed));
							}

							echo $part;
						}
					} else {
						echo $body;
					}
				}

				return;
			}
			$allowed = array_keys($route);
			break;
		}
		if (!$allowed)
		// URL不匹配任何路由模式
		{
			$this->error(404);
		} elseif (PHP_SAPI != 'cli') {
			// 不能执行HTTP方法
			header('Allow: ' . implode(',', $allowed));
			if ($this->hive['VERB'] != 'OPTIONS') {
				$this->error(405);
			}
		}

	}
}

return Base::instance();