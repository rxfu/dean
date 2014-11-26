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
		return self::_started() ? session_regenerate_id(true) : session_start();
	}

	/**
	 * 在指定时间内会话未激活则设置过期
	 * @return void
	 */
	private static function _age() {
		$last = isset($_SESSION['LAST_ACTIVE']) ? $_SESSION['LAST_ACTIVE'] : false;

		if (false !== $last && (time() - $last > self::SESSION_AGE)) {
			self::destroy();
			App::error(SESS_ERROR, '会话已过期');
		}

		$_SESSION['LAST_ACTIVE'] = time();
	}

	/**
	 * 判断会话是否开启
	 * @return boolean 会话开启则为TRUE，未开启则为FALSE
	 */
	private static function _started() {
		$started = false;
		if (version_compare(phpversion(), '5.4.0', '>=')) {
			$started = session_status() === PHP_SESSION_ACTIVE ? true : false;
		} else {
			$started = session_id() === '' ? false : true;
		}

		return $started;
	}

	/**
	 * 写入会话数据
	 * @param  string $key   会话名称或会话数组
	 * @param  string $value 会话值
	 * @return string 写入会话数据
	 */
	public static function write($key, $value = '') {
		if (!is_string($key)) {
			App::error(SESS_ERROR, '无效会话参数类型');
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
			App::error(SESS_ERROR, '无效会话参数类型');
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
			App::error(SESS_ERROR, '无效会话参数类型');
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
	 * 添加flash消息
	 * @param  string $type    消息类型
	 * @param  string $message 消息内容
	 * @return void
	 */
	public static function flash($type, $message) {
		if (!is_string($type) || !is_string($message)) {
			App::error(SESS_ERROR, '无效消息类型');
		}

		$types = array('info', 'error', 'success', 'warning', 'danger');
		$type  = strtolower($type);

		if (!in_array($type, $types)) {
			$type = 'unknown';
		}

		self::_init();

		if (!isset($_SESSION['flash'])) {
			$_SESSIION['flash'] = array();
		}
		if (!array_key_exists($type, $_SESSION['flash'])) {
			$_SESSION['flash'][$type] = array();
		}

		$_SESSION['flash'][$type][] = $message();
	}

	/**
	 * 显示flash消息
	 * @param  string  $type  消息类型
	 * @param  boolean $print 输出标志，输出为TRUE，返回数据为FALSE
	 * @return mixed         格式化后的flash数据
	 */
	public static function render($type = 'all', $print = true) {
		if (is_null($type) || !is_string($type)) {
			App::error(SESS_ERROR, '无效消息类型');
		}

		self::_init();

		if (!isset($_SESSION['flash'])) {
			return false;
		}

		if ('all' === $type) {
			foreach ($_SESSION['flash'] as $type => $message) {
				$flash = '<div id="flash_' . $type . '" class="alert alert-dismissable alert-' . $type . '">';
				$flash .= '<button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$flash .= $message;
				$flash .= '</div>';
			}

			$this->clear();
		} else {
			if (!isset($_SESSION['flash'][$type])) {
				$type = 'unknown';
			}

			foreach ($_SESSION['flash'][$type] as $message) {
				$flash = '<div id="flash_' . $type . '" class="alert alert-dismissable alert-' . $type . '">';
				$flash .= '<button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$flash .= $message;
				$flash .= '</div>';
			}

			$this->clear($type);
		}

		if ($print) {
			echo $flash;
		} else {
			return $flash;
		}
	}

	/**
	 * 判断对应类型中是否有消息
	 * @param  string  $type 消息类型
	 * @return boolean       有消息内容则为TRUE，无消息内容则为FALSE
	 */
	public static function has($type) {
		if (is_null($type) || !is_string($type)) {
			App::error(SESS_ERROR, '无效消息类型');
		}

		return !empty($_SESSION['flash'][$type]);
	}

	/**
	 * 清除消息记录
	 * @param  string $type 消息类型
	 * @return boolean       成功为TRUE，失败为FALSE
	 */
	public static function clear($type = 'all') {
		if (!is_string($type)) {
			App::error(SESS_ERROR, '无效消息类型');
		}

		if ('all' === $type) {
			self::delete('flash');
		} else {
			self::delete('flash.' . $type);
		}

		return true;
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
		if (self::_started()) {
			return session_write_close();
		}

		return true;
	}

	/**
	 * 销毁会话，并删除会话数据
	 * @return void
	 */
	public static function destroy() {
		if (self::_started()) {
			$_SESSION = array();

			if (ini_get('session.use_cookies')) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
			}

			session_destroy();
		}
	}
}
