<?php

/**
 * 字典模型类
 */
class DictionaryModel extends Model {

	/**
	 * 字典表前缀
	 * @var string
	 */
	private $_prefix = 't_zd_';

	/**
	 * 根据字典代码获得对应的中文名称
	 * @param  string $table 字典名称
	 * @param  string $code    字典代码
	 * @return string        中文名称
	 */
	public function get($table, $code) {
		$sql  = 'SELECT mc FROM ' . $this->_prefix . $table . ' WHERE dm = ?';
		$data = $this->db->getRow($sql, $code);

		return empty($data['mc']) ? '未知' : $data['mc'];
	}

	/**
	 * 遍历字典表
	 * @param  string $table 字典名称
	 * @return array        字典列表
	 */
	public function getAll($table) {
		$data = $this->db->searchRecord($this->_prefix . $table);

		return $data;
	}
}