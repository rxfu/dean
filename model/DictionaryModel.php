<?php

/**
 * 字典模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class DictionaryModel extends Model {

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
	 * 根据字典代码获得对应的中文名称
	 * @param  string $name 字典名称
	 * @param  string $code    字典代码
	 * @param string $prefix 前缀
	 * @param string $key 代码字段
	 * @param string $value 名称字段
	 * @return string        中文名称
	 */
	public function get($name, $code, $prefix, $key, $value) {
		$table = 't_' . $prefix . '_' . $name;
		$sql   = 'SELECT ' . $value . ' FROM ' . $table . ' WHERE ' . $key . ' = ?';
		$data  = $this->db->getRow($sql, $code);

		return empty($data['mc']) ? '未知' : $data['mc'];
	}

	/**
	 * 遍历字典表
	 * @param  string $name 字典名称
	 * @param string $prefix 前缀
	 * @return array        字典列表
	 */
	public function getAll($name, $prefix) {
		$table = 't_' . $prefix . '_' . $name;
		$data  = $this->db->searchRecord($table);

		return $data;
	}

}