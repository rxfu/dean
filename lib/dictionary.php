<?php

/**
 * 字典类
 */
final class Dictionary extends Prefab {

	/**
	 * 字典表前缀
	 * @var string
	 */
	private static $_prefix = null;

	/**
	 * 数据库连接唯一标识符
	 * @var object
	 */
	private static $_dbh = null;

	/**
	 * 初始化字典表
	 * @return void
	 */
	protected function init() {
		self::$_prefix = 't_zd_';
		self::$_dbh    = DB::getInstance();
	}

	/**
	 * 根据字典代码获得对应的中文名称
	 * @param  string $table 字典名称
	 * @param  string $code    字典代码
	 * @return string        中文名称
	 */
	public static function get($table, $code) {
		$dict = self::getInstance();

		$sql  = 'SELECT mc FROM ' . self::$_prefix . $table . ' WHERE dm = ?';
		$data = $dict::$_dbh->getRow($sql, $code);

		return empty($data['mc']) ? '未知' : $data['mc'];
	}

	/**
	 * 遍历字典表
	 * @param  string $table 字典名称
	 * @return array        字典列表
	 */
	public static function getAll($table) {
		$dict = self::getInstance();

		$data = $dict::$_dbh->searchRecord(self::$_prefix . $table);

		return $data;
	}

}