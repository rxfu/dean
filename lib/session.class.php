<?php

/**
 * 会话控制类
 */
class Session extends Prefab {

	/**
	 * 会话生存时间
	 *
	 * @var integer
	 */
	private $ttl = 0;

	/**
	 * 会话控制类构造函数
	 */
	public function __construct() {
		if (!$this->id()) {
			$this->setUseTransSID(SESSION_USE_TRANS_SID);
			$this->setUseCookies(SESSION_USE_COOKIES, SESSION_USE_ONLY_COOKIES);
			$this->setExpiredTime(SESSION_EXPIRATION);
			$this->_start();
		}
	}

	/**
	 * 设置或获取当前session的id
	 *
	 * @param string  $id session的id
	 * @return string  session的id
	 */
	public function id($id = null) {
		return isset($id) ? session_id($id) : session_id();
	}

	/**
	 * 设置或获取当前session名称
	 *
	 * @param string  $name session名称
	 * @return string    session名称
	 */
	public function name($name = null) {
		return isset($name) ? session_name($name) : session_name();
	}

	/**
	 * 设置session值
	 *
	 * @param string  $name  session名称
	 * @param string  $value session值
	 */
	public function set($name, $value = '') {
		$data = is_array($name) ? $name : array($name => $value);
		if (0 < count($data)) {
			foreach ($data as $key => $val) {
				$_SESSION[$key] = $val;
			}
		}
	}

	/**
	 * 获取session值
	 *
	 * @param string  $name session名称
	 * @return string    session值
	 */
	public function get($name) {
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}

	/**
	 * 清除session值
	 *
	 * @param string  $name session名称
	 */
	public function erase($name) {
		$data = is_array($name) ? $name : array($name => '');
		if (0 < count($data)) {
			foreach (array_keys($data) as $key) {
				unset($_SESSION[$key]);
			}
		}
	}

	/**
	 * 保存session值
	 */
	public function commit() {
		session_write_close();
	}

	/**
	 * 检查session值是否已经设置
	 *
	 * @param string  $name session名称
	 * @return boolean    已经设置为TRUE，未设置为FALSE
	 */
	public function has($name) {
		return isset($_SESSION[$name]);
	}

	/**
	 * 销毁session
	 */
	public function destroy() {
		$_SESSION = array();

		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time() - 42000, '/');
		}

		session_destroy();
	}

	/**
	 * 设置session的use_trans_sid
	 *
	 * @param boolean $useTransSid use_trans_sid值
	 */
	public function setUseTransSID($useTransSid = null) {
		$config = ini_get('session.use_trans_sid') ? true : false;

		if (isset($useTransSid)) {
			ini_set('session.use_trans_sid', $useTransSid ? 1 : 0);
		}

		return $config;
	}

	/**
	 * 设置是否使用cookie，以及是否仅使用cookie
	 *
	 * @param boolean $useCookies use_cookies值
	 * @param boolean $only       use_only_cookies值
	 */
	public function setUseCookies($useCookies = null, $only = null) {
		$config = ini_get('session.use_cookies') ? true : false;

		if (isset($useCookies)) {
			ini_set('session.use_cookies', $useCookies ? 1 : 0);
			if (isset($only)) {
				ini_set('session.use_only_cookies', $only ? 1 : 0);
			}
		}

		return $config;
	}

	/**
	 * 设置session会话超时间
	 *
	 * @param int     $expiredTime gc_maxlifetime值
	 */
	public function setExpiredTime($expiredTime = null) {
		$config = ini_get('session.gc_maxlifetime');

		if (isset($expiredTime) && is_int($expiredTime) && 1 <= $expiredTime) {
			ini_set('session.gc_maxlifetime', $expiredTime);
		}

		return $config;
	}

	/**
	 * 重新生成session的id
	 */
	public function regenerateId() {

		// 保存旧session id和数据
		$oldId   = session_id();
		$oldData = $_SESSION;

		// 重新生成session id并保存新session id
		session_regenerate_id();
		$newId = session_id();

		// 交换到旧session，并销毁其存储数据
		session_id($oldId);
		session_destroy();

		// 交换回新session，并重新启动会话
		session_id($newId);
		session_start();

		// 恢复旧session数据到新session
		$_SESSION = $oldData;

		// 更新session创建时间
		$_SESSION['regenerated'] = time();

		// 结束当前session，并立即保存
		session_write_close();
	}

	/**
	 * 启动session
	 */
	private function _start() {
		if (session_start() === false) {
			throw new RuntimeException('不能启动会话。session_start()出现未知错误！');
		}

		$expiredTime = ini_get('session.gc_maxlifetime');
		if (is_numeric($expiredTime)) {
			$this->ttl = (0 < $expiredTime) ? $expiredTime : (60 * 60 * 24 * 365 * 2);
		}

		if ($this->_isExpired()) {
			$this->regenerateId();
		}
	}

	/**
	 * 检查会话是否已经超时
	 *
	 * @return boolean 超时为TRUE，未超时为FALSE
	 */
	private function _isExpired() {
		if (!isset($_SESSION['regenerated'])) {
			$_SESSION['regenerated'] = time();
			return false;
		}

		return (time() - $this->ttl) >= $_SESSION['regenerated'] ? true : false;
	}

	/**
	 * 判断Session是否开启
	 * @return boolean 开启为TRUE，未开启为FALSE
	 */
	public function isStarted() {
		$started = false;
		if (version_compare(phpversion(), '5.4.0', '>=')) {
			$started = session_status() === PHP_SESSION_ACTIVE ? true : false;
		} else {
			$started = session_id() === '' ? false : true;
		}

		return $started;
	}

}
