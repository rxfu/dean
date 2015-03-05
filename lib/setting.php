<?php

/**
 * 系统设置类
 */
final class Setting {

	use Singleton;

	/**
	 * 系统参数表
	 * @var string
	 */
	private static $_table = null;

	/**
	 * 获取系统参数
	 * @param  string $id 系统参数名
	 * @return string     系统参数值
	 */
	public static function get($id) {
		$setting = new SettingModel();

		return $setting->get($id);
	}

}