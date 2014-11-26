<?php

/**
 * 会话控制类
 */
class Session {

	/**
	 * 会话生存时间
	 *
	 * @var integer
	 */
	private static $SESSION_AGE = SESS_EXPIRATION;

	/**
	 * 初始化新会话并保存原有会话
	 * @return boolean 会话创建成功返回TRUE，否则返回FALSE
	 */
	private static function _init() {
		$started = false;
		if (version_compare(phpversion(), '5.4.0', '>=')) {
			$started = session_status() === PHP_SESSION_ACTIVE ? true : false;
		} else {
			$started = session_id() === '' ? false : true;
		}

		return $started ? session_regenerate_id(true) : session_start();
	}

	/**
	 * 在指定时间内会话未激活则设置过期
	 * @return void
	 */
	private static function _age() {
		$last = isset($_SESSION['LAST_ACTIVE']) ? $_SESSION['LAST_ACTIVE'] : false;

		if (false !== $last && (time() - $last > self::SESSION_AGE)) {
			self::destroy();
			$app = App::getInstance();
			$app->error(SESS_ERROR, '会话已过期');
		}

		$_SESSION['LAST_ACTIVE'] = time();
	}

	/**
	 * 写入会话数据
	 * @param  string $key   会话名称或会话数组
	 * @param  string $value 会话值
	 * @return string 写入会话数据
	 */
	public static function write($key, $value = '') {
		if (!is_string($key) || !is_string($value)) {
			$app = App::getInstance();
			$app->error(SESS_ERROR, '无效会话参数类型');
		}

		self::_init();

		$keys    = explode('.', $key);
		$session = &$_SESSION;
		foreach ($keys as $name) {
			$session = &$session[$name];
		}
		$session = $value;

		self::_age();

		return $value;
	}

	/**
	 * 读取会话数据
	 * @param  string $key 会话名称
	 * @return mixed      成功返回会话数据，否则返回FALSE
	 */
	public static function read($key) {
		if (!is_string($key)) {
			$app = App::getInstance();
			$app->error(SESS_ERROR, '无效会话参数类型');
		}

		self::_init();

		$keys    = explode('.', $key);
		$session = &$_SESSION;
		foreach ($keys as $name) {
			$session = &$session[$name];
		}

		if (isset($session)) {
			self::_age();

			return $session;
		}

		return false;
	}

	/**
	 * 删除会话数据
	 * @param  string $key 会话名称
	 * @return void
	 */
	public static function delete($key) {
		if (!is_string($key)) {
			$app = App::getInstance();
			$app->error(SESS_ERROR, '无效会话参数类型');
		}

		self::_init();

		$keys    = explode('.', $key);
		$session = &$_SESSION;
		foreach ($keys as $name) {
			$session = &$session[$name];
		}
		unset($session);

		self::_age();
	}

	/**
	 * 显示当前会话数据
	 * @return void
	 */
	public static function dump() {
		self::_init();
		echo nl2br(print_r($_SESSION));
	}

	/**
	 * 启动会话
	 * @return boolean 成功返回TRUE，否则返回FALSE
	 */
	public static function start() {
		return self::_init();
	}

	/**
	 * 获取当前cookie参数
	 * @return array Cookie参数
	 */
	public static function params() {
		$params = array();

		if ('' !== session_id()) {
			$params = session_get_cookie_params();
		}

		return $params;
	}

	/**
	 * 关闭当前会话，并且释放会话文件锁定
	 * @return boolean 成功返回TRUE，失败返回FALSE
	 */
	public static function close() {
		if ('' !== session_id()) {
			return session_write_close();
		}

		return true;
	}

	/**
	 * 销毁会话，并删除会话数据
	 * @return void
	 */
	public static function destroy() {
		if ('' !== session_id()) {
			$_SESSION = array();

			if (ini_get('session.use_cookies')) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
			}

			session_destroy();
		}
	}
}
