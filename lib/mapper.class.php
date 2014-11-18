<?php

/**
 * 数据映射类
 */
class Mapper {

	/**
	 * PDO实例
	 * @var string
	 */
	protected $db;
	/**
	 * 数据库引擎
	 * @var string
	 */
	protected $engine;
	/**
	 * 数据表名
	 * @var string
	 */
	protected $table;
	/**
	 * 最后一次插入数据的ID
	 * @var string
	 */
	protected $id;

	/**
	 * 实例化数据库映射类
	 * @param object $db    DB数据库实例
	 * @param string $table 表名
	 */
	public function __construct($db, $table) {
		$this->db     = $db;
		$this->engine = $db->driver();
		if ($this->engine = 'oci') {
			$table = strtoupper($table);
		}
		$this->table = $table;
	}
}