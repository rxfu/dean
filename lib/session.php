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
	private static $_session_age = SESSION_EXPIRATION;

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
	 * 在指定时间内会话未激活则设置过期
	 * @return void
	 */
	private static function _age() {
		$last = isset($_SESSION['LAST_ACTIVE']) ? $_SESSION['LAST_ACTIVE'] : false;

		if (false !== $last && (time() - $last > self::$_session_age)) {
			self::destroy();
			trigger_error('会话已过期', E_USER_WARNING);
			return;
		}

		$_SESSION['LAST_ACTIVE'] = time();
	}

	/**
	 * 判断会话是否开启
	 * @return boolean 会话开启则为TRUE，未开启则为FALSE
	 */
	public static function isStarted() {
		$started = false;
		if (version_compare(phpversion(), '5.4.0', '>=')) {
			$started = (PHP_SESSION_ACTIVE === session_status() ? true : false);
		} else {
			$started = ('' === session_id() ? false : true);
		}

		return $started;
	}

	/**
	 * 写入会话数据
	 * @param  string $key   会话名称或会话数组
	 * @param  mixed $value 会话值
	 * @return string 写入会话数据
	 */
	public static function set($key, $value = false) {
		self::_init();

		if (is_array($key) && false === $value) {
			foreach ($key as $name => $value) {
				$_SESSION[SESSION_PREFIX . $name] = $value;
			}
		} else {
			$_SESSION[SESSION_PREFIX . $key] = $value;
		}

		self::_age();

		return $value;
	}

	/**
	 * 读取会话数据
	 * @param  string $key 会话名称
	 * @param  string $child 子会话名称
	 * @return mixed      成功返回会话数据，否则返回FALSE
	 */
	public static function get($key, $child = false) {
		if (!is_string($key)) {
			trigger_error('无效会话参数类型', E_USER_ERROR);
			return false;
		}

		self::_init();

		if (false === $child) {
			if (isset($_SESSION[SESSION_PREFIX . $key])) {
				return $_SESSION[SESSION_PREFIX . $key];
			}
		} else {
			if (isset($_SESSION[$key][$child])) {
				return $_SESSION[$key][$child];
			}
		}

		self::_age();

		return false;
	}

	/**
	 * 删除会话数据
	 * @param  string $key 会话名称
	 * @return mixed 删除的会话数据
	 */
	public static function delete($key) {
		if (!is_string($key)) {
			trigger_error('无效会话参数类型', E_USER_ERROR);
			return;
		}

		self::_init();

		$value = $_SESSION[SESSION_PREFIX . $key];
		unset($_SESSION[SESSION_PREFIX . $key]);

		self::_age();

		return $value;
	}

	/**
	 * 判断是否有会话数据
	 * @param  string  $key 会话名称
	 * @return boolean       有会话数据则为TRUE，无会话数据则为FALSE
	 */
	public static function has($key) {
		if (!is_string($key)) {
			trigger_error('无效会话参数类型', E_USER_ERROR);
			return;
		}

		return isset($_SESSION[$key]);
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

		if (self::_started()) {
			$params = session_get_cookie_params();
		}

		return $params;
	}

	/**
	 * 关闭当前会话，并且释放会话文件锁定
	 * @return boolean 成功返回TRUE，失败返回FALSE
	 */
	public static function close() {
		if (self::isStarted()) {
			return session_write_close();
		}

		return true;
	}

	/**
	 * 销毁会话，并删除会话数据
	 * @return void
	 */
	public static function destroy() {
		if (self::isStarted()) {
			session_unset();

			if (ini_get('session.use_cookies')) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
			}

			session_destroy();
		}
	}

	/**
	 * 重新生成回话ID
	 * @return string session id数据
	 */
	public static function regenerate() {
		if (isset($_SESSION['regenerate'])) {
			if (true === $_SESSION['regenerate']) {
				return session_id();
			}
		}

		return session_regenerate_id(true);
	}
}
