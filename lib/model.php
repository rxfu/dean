<?php

/**
 * 模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class Model {

	/**
	 * 模型类对应的数据库句柄
	 * @var object
	 */
	protected $db = null;

	/**
	 * 数据库角色
	 * @var string
	 */
	private $_role = null;

	/**
	 * 模型类构造方法
	 */
	public function __construct() {
		$this->_role = is_null($this->_role) ? 'default' : $this->_role;
		$dsn         = Config::get('db.' . $this->_role);
		$this->db    = Database::getInstance($dsn);
	}

	/**
	 * 设置数据库角色
	 * @param string $role 数据库角色
	 */
	public function setRole($role) {
		$this->_role = $role;
	}

}