<?php

/**
 * 模型类
 */
class Model {

	/**
	 * 模型类对应的数据库句柄
	 * @var object
	 */
	protected $db = null;

	/**
	 * 模型类控制方法
	 */
	public function __construct() {
		$this->db = Database::getInstance();
	}
}