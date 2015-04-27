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
	 * @return string        中文名称
	 */
	public static function get($table, $code) {
		$dict = new DictionaryModel();

		return $dict->get($table, $code);
	}

	/**
	 * 遍历字典表
	 * @param  string $table 字典名称
	 * @return array        字典列表
	 */
	public static function getAll($table) {
		$dict = new DictionaryModel();

		return $dict->getAll($table);
	}

}