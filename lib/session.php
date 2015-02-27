<?php

/**
 * 会话控制类
 */
class Session extends SessionHandler {

	use Singleton;

	/**
	 * 数据加密密钥
	 * @var string
	 */
	protected $key;

	/**
	 * 会话名称
	 * @var string
	 */
	protected $name;

	/**
	 * Cookie数据
	 * @var array
	 */
	protected $cookie;

	/**
	 * 会话构造函数
	 * @param string $key    数据加密钥
	 * @param string $name   会话名称
	 * @param array $cookie cookie数据
	 */
	public function __construct($key, $name = SESSION_NAME, $cookie = []) {
		$this->key    = $key;
		$this->name   = $name;
		$this->cookie = $cookie;

		$this->cookie += array(
			'lifetime' => 0,
			'path'     => ini_get('session.cookie_path'),
			'domain'   => ini_get('session.cookie_domain'),
			'secure'   => isset($_SERVER['HTTPS']),
			'httponly' => true,
		);

		$this->setup();
	}

	/**
	 * 设置会话参数
	 * @return void
	 */
	protected function setup() {
		ini_set('session.use_cookies', 1);
		ini_set('session.use_only_cookies', 1);

		session_name($this->name);

		session_set_cookie_params($this->cookie['lifetime'], $this->cookie['path'], $this->cookie['domain'], $this->cookie['secure'], $this->cookie['httponly']);
	}

	/**
	 * 启动会话
	 * @return boolean 启动成功返回TRUE，否则为FALSE
	 */
	public function start() {
		if (!$this->isStarted()) {
			if (session_start()) {
				return (0 === mt_rand(0, 4)) ? $this->refresh() : true;
			}
		}

		return false;
	}

	/**
	 * 销毁会话，并清除会话数据
	 * @return boolean 成功为TRUE，失败为FALSE
	 */
	public function forget() {
		if (!$this->isStarted) {
			return false;
		}

		session_unset();

		setcookie($this->name, '', time() - 42000, $this->cookie['path'], $this->cookie['domain'], $this->cookie['secure'], $this->cookie['httponly']);

		return session_destory();
	}

	/**
	 * 重新生成会话ID
	 * @return string session id数据
	 */
	public function refresh() {
		return session_regenerate_id(true);
	}

	/**
	 * 解密会话数据
	 * @param  string $id 会话ID
	 * @return string     解密后数据
	 */
	public function read($id) {
		return mcrypt_decrypt(MCRYPT_3DES, $this->key, parent::read($id), MCRYPT_MODE_ECB);
	}

	/**
	 * 加密会话数据
	 * @param  string $id   会话ID
	 * @param  string $data 会话数据
	 * @return string       加密后数据
	 */
	public function write($id, $data) {
		return parent::write($id, mcrypt_encrypt(MCRYPT_3DES, $this->key, $data, MCRYPT_MODE_ECB));
	}

	/**
	 * 检测会话是否过期
	 * @param  integer $ttl 会话过期时间
	 * @return boolean      过期为TRUE，否则为FALSE
	 */
	public function isExpired($ttl = SESSION_TTL) {
		$activity = isset($_SESSION['_last_activity']) ? $_SESSION['_last_activity'] : false;

		if (false !== $activity && $ttl * 60 < time() - $activity) {
			return true;
		}

		$_SESSION['_last_activity'] = time();

		return false;
	}

	/**
	 * 检测会话指纹信息
	 * @return boolean 匹配为TRUE，否则为FALSE
	 */
	public function isFingerprint() {
		$hash = md5($_SERVER['USER_AGENT'] . (ip2long($_SERVER['REMOTE_ADDR']) & ip2long('255.255.0.0')));

		if (isset($_SESSION['_fingerprint'])) {
			return $_SESSION['_fingerprint'] === $hash;
		}

		$_SESSION['_fingerprint'] = $hash;

		return true;
	}

	/**
	 * 检测会话是否有效
	 * @param  integer $ttl 会话过期时间
	 * @return boolean      有效为TRUE，否则为FALSE
	 */
	public function isValid($ttl = SESSION_TTL) {
		return !$this->isExpired($ttl) && $this->isFingerprint();
	}

	/**
	 * 读取会话数据
	 * @param  string $name 会话名称
	 * @return mixed      成功返回会话数据，否则返回null
	 */
	public function get($name) {
		$parsed = explode('.', $name);

		$result = $_SESSION;

		while ($parsed) {
			$next = array_shift($parsed);

			if (isset($result[$next])) {
				$result = $result[$next];
			} else {
				return null;
			}
		}

		return $result;
	}

	/**
	 * 写入会话数据
	 * @param  string $name   会话名称
	 * @param  mixed $value 会话值
	 * @return string 写入会话数据
	 */
	public function put($name, $value = false) {
		$parsed = explode('.', $name);

		$session = &$_SESSION;

		while (1 < count($parsed)) {
			$next = array_shift($parsed);

			if (!isset($session[$next]) || !is_array($session[$next])) {
				$session[$next] = [];
			}

			$session = &$session[$next];
		}

		$session[array_shift($parsed)] = $value;
	}

	/**
	 * 初始化新会话并保存原有会话
	 * @return boolean 会话创建成功返回TRUE，否则返回FALSE
	 */
	private static function _init() {
		// return self::_started() ? self::regenerate() : session_start();
		if (false == self::isStarted()) {
			session_start();
		}
	}

	/**
	 * 判断会话是否开启
	 * @return boolean 会话开启则为TRUE，未开启则为FALSE
	 */
	protected function isStarted() {
		$started = false;
		if (version_compare(phpversion(), '5.4.0', '>=')) {
			$started = (PHP_SESSION_ACTIVE === session_status() ? true : false);
		} else {
			$started = ('' === session_id() ? false : true);
		}

		return $started;
	}

	/**
	 * 判断是否有会话数据
	 * @param  string  $key 会话名称
	 * @return boolean       有会话数据则为TRUE，无会话数据则为FALSE
	 */
	public function has($key) {
		return isset($_SESSION[$key]);
	}

	/**
	 * 显示当前会话数据
	 * @return void
	 */
	public function dump() {
		echo nl2br(print_r($_SESSION));
	}

	/**
	 * 获取当前cookie参数
	 * @return array Cookie参数
	 */
	public function params() {
		$params = array();

		if ($this->isStarted()) {
			$params = session_get_cookie_params();
		}

		return $params;
	}

	/**
	 * 关闭当前会话，并且释放会话文件锁定
	 * @return boolean 成功返回TRUE，失败返回FALSE
	 */
	public function close() {
		if ($this->isStarted()) {
			return session_write_close();
		}

		return false;
	}

}
