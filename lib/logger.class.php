<?php

/**
 * 日志类
 */
class Logger extends Prefab {

	/**
	 * 日志表
	 * @var string
	 */
	private static $table = null;

	/**
	 * 数据库连接唯一标识符
	 * @var object
	 */
	private static $_dbh = null;

	/**
	 * 初始化日志表
	 * @return void
	 */
	protected function init() {
		self::$table = 't_xk_log';
		self::$_dbh  = DB::getInstance();
	}

	/**
	 * 写入日志
	 * @param  array $log 日志数据
	 * @return void
	 */
	public static function write($log) {
		if (isset($log) && is_array($log)) {
			$logger = self::getInstance();

			$data['ip']   = getClientIp();
			$data['czsj'] = date('Y-m-d H:i:s');
			$expected     = array('xh', 'kcxh', 'kcmc', 'kcxz', 'czlx', 'bz');
			foreach ($expected as $key) {
				$data[$key] = isset($log[$key]) ? $log[$key] : null;
			}

			$logger::$_dbh->insertRecord($table, $data);
		}
	}

	/**
	 * 读取日志
	 * @param  string $id 学号
	 * @return array     日志数据
	 */
	public static function read($id) {
		$data = null;
		if (isset($id) && is_string($id)) {
			$logger = self::getInstance();
			$data   = $logger::$_dbh->searchRecord($table, array('xh' => $id));
		}
		return $data;
	}
}