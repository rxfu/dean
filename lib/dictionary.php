<?php

/**
 * 字典类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
final class Dictionary {

	use Singleton;

	/**
	 * 根据字典代码获得对应的中文名称
	 * @param  string $table 字典名称
	 * @param  string $code    字典代码
	 * @param string $prefix 前缀
	 * @param string $key 代码字段
	 * @param string $value 名称字段
	 * @return string        中文名称
	 */
	public static function get($table, $code, $prefix = 'zd', $key = 'dm', $value = 'mc') {
		$dict = new DictionaryModel();

		return $dict->get($table, $code, $prefix, $key, $value);
	}

	/**
	 * 遍历字典表
	 * @param  string $table 字典名称
	 * @param string $prefix 前缀
	 * @return array        字典列表
	 */
	public static function getAll($table, $prefix = 'zd') {
		$dict = new DictionaryModel();

		return $dict->getAll($table, $prefix);
	}

}