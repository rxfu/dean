<?php

/**
 * 系统设置模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class SettingModel extends Model {

	/**
	 * 系统参数表
	 * @var string
	 */
	private $_table = 't_xt';

	public function __construct() {
		$session = Session::getInstance(Config::get('session.key'));
		switch ($session->get('role')) {
			case 'student':
				$dbcfg = 'student';
				break;

			case 'teacher':
				$dbcfg = 'teacher';
				break;

			default:
				$dbcfg = 'default';
				break;
		}

		parent::__construct($dbcfg);
	}

	/**
	 * 获取系统参数
	 * @param  string $id 系统参数名
	 * @return string     系统参数值
	 */
	public function get($id) {
		$sql   = 'SELECT value FROM ' . $this->_table . ' WHERE id = ?';
		$value = $this->db->getColumn($sql, $id);

		return $value;
	}

}