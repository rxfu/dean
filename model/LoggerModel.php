<?php

/**
 * 日志模型类
 */
class LoggerModel extends Model {

	/**
	 * 日志表
	 * @var string
	 */
	private $_table = 't_xk_log';

	/**
	 * 写入日志
	 * @param  array $log 日志数据
	 * @return void
	 */
	public function write($log) {
		if (isset($log) && is_array($log)) {
			$data['ip']   = getClientIp();
			$data['czsj'] = date('Y-m-d H:i:s');
			$expected     = array('xh', 'kcxh', 'kcmc', 'czlx', 'bz');
			foreach ($expected as $key) {
				$data[$key] = isset($log[$key]) ? $log[$key] : null;
			}

			$this->db->insertRecord($this->_table, $data);
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
			$data = $this->db->searchRecord($this->_table, array('xh' => $id));
		}
		return $data;
	}
}