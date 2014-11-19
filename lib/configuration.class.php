<?php

/**
 * 配置类，用于配置系统参数
 */
final class Configuration extends Prefab {

	/**
	 * 存储配置数据
	 * @var array
	 */
	private $_values = array();

	/**
	 * 配置文件路径
	 * @var string
	 */
	private $_configDirectory = '..';

	/**
	 * 获取配置值
	 * @param  string $key 配置参数
	 * @return mixed      配置值
	 */
	public static function get($key) {
		return $_values[$key];
	}

	/**
	 * 设置配置值
	 * @param string $key   配置参数
	 * @param mixed $value 配置值
	 */
	public static function set($key, $value) {
		$_values[$key] = $value;
	}

	/**
	 * 判断配置值是否存在
	 * @param  string $key 配置参数
	 * @return boolean      存在为TRUE，不存在为FALSE
	 */
	public static function exists($key) {
		return isset($_value[$key]);
	}

	/**
	 * 加载配置文件
	 * @param  string $config 配置文件
	 * @return NULL
	 */
	public static function load($config = NULL) {
		if (is_null($config)) {
			$config = 'config';
		}
		$cfgPath = $this->_configDirectory . DIRECTORY_SEPARATOR . $config . '.php';
		if (!is_file($cfgFile)) {
			throw new RuntimeException('配置文件 ' . $cfgFile . ' 不存在！');
		}

		$_value = require $cfgPath;
	}

}