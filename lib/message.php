<?php

/**
 * 消息类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class Message {

	/**
	 * 消息类型
	 * @var array
	 */
	private static $_types = array('info', 'success', 'warning', 'danger');

	/**
	 * 初始化消息
	 * @return void
	 */
	protected static function _init() {
		if (!array_key_exists('flash', $_SESSION)) {
			$_SESSION['flash'] = array();
		}
	}

	/**
	 * 添加消息
	 * @param string $type    消息类型
	 * @param string $message 消息内容
	 * @return  boolean 成功为TRUE，失败为FALSE
	 */
	public static function add($type, $message) {
		if (!isset($_SESSION['flash'])) {
			self::_init();
		}

		if (!isset($type) || !isset($message[0])) {
			return false;
		}

		if (!in_array($type, self::$_types)) {
			trigger_error('无效消息类型', E_USER_ERROR);
			return;
		}

		self::_init();
		if (!array_key_exists($type, $_SESSION['flash'])) {
			$_SESSION['flash'][$type] = array();
		}
		$_SESSION['flash'][$type][] = $message;

		return true;
	}

	/**
	 * 显示消息
	 * @param  string  $type  消息类型
	 * @param  boolean $print 输出标志，输出为TRUE，返回数据为FALSE
	 * @return mixed         格式化后的消息
	 */
	public static function display($type = 'all', $print = true) {
		if (is_null($type) || !is_string($type)) {
			trigger_error('无效消息类型', E_USER_ERROR);
			return;
		}

		if (!isset($_SESSION['flash'])) {
			return false;
		}

		if (in_array($type, self::$_types)) {
			foreach ($_SESSION['flash'][$type] as $message) {
				$data = '<div id="flash_' . $type . '" class="alert alert-dismissable alert-' . $type . '">';
				$data .= '<button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$data .= $message;
				$data .= '</div>';
			}

			self::clear($type);
		} elseif ('all' === $type) {
			foreach ($_SESSION['flash'] as $type => $messages) {
				foreach ($messages as $message) {
					$data = '<div id="flash_' . $type . '" class="alert alert-dismissable alert-' . $type . '">';
					$data .= '<button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$data .= $message;
					$data .= '</div>';
				}
			}

			self::clear();
		} else {
			return false;
		}

		if ($print) {
			echo $data;
		} else {
			return $data;
		}
	}

	/**
	 * 判断是否有消息
	 * @param  string  $type 消息类型
	 * @return boolean       有消息内容则为TRUE，无消息内容则为FALSE
	 */
	public static function has($type = null) {
		if (isset($_SESSION['flash'])) {
			if (!is_null($type) && is_string($type)) {
				if (!empty($_SESSION['flash'][$type])) {
					return $_SESSION['flash'][$type];
				}
			} else {
				foreach (self::$_types as $type) {
					if (!empty($_SESSION['flash'])) {
						return true;
					}
				}
			}
		}

		return false;
	}
	/**
	 * 清除消息记录
	 * @param  string $type 消息类型
	 * @return boolean       成功为TRUE，失败为FALSE
	 */
	public static function clear($type = 'all') {
		if (!is_string($type)) {
			trigger_error('无效消息类型', E_USER_ERROR);
			return;
		}

		if ('all' === $type) {
			unset($_SESSION['flash']);
		} else {
			unset($_SESSION['flash'][$type]);
		}

		return true;
	}

}