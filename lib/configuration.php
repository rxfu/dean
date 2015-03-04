<?php

/**
 * 系统配置类
 */
final class Configuration {

	use Singleton;

	/**
	 * 系统参数表
	 * @var string
	 */
	private static $_table = null;

	/**
	 * 数据库连接唯一标识符
	 * @var object
	 */
	private static $_dbh = null;

	/**
	 * 初始化系统参数表
	 * @return void
	 */
	protected function init() {
		self::$_table = 't_xt';
		self::$_dbh   = Database::getInstance();
	}

	/**
	 * 获取系统参数
	 * @param  string $id 系统参数名
	 * @return string     系统参数值
	 */
	public static function get($id) {
		$config = self::getInstance();
		$sql    = 'SELECT value FROM ' . self::$_table . ' WHERE id = ?';
		$data   = $config::$_dbh->getRow($sql, $id);

		return $data['value'];
	}

}