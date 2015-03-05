<?php

/**
 * 日志类
 */
class Logger {

	use Singleton;

	/**
	 * 写入日志
	 * @param  array $log 日志数据
	 * @return void
	 */
	public static function write($log) {
		$logger = new LoggerModel();
		$logger->write($log);
	}

	/**
	 * 读取日志
	 * @param  string $id 学号
	 * @return array     日志数据
	 */
	public static function read($id) {
		$logger = new LoggerModel();
		return $logger->read($id);
	}
}