<?php

/**
 * 配置类
 */
final class Config {
	
	use Singleton;

	/**
	 * 配置文件路径列表
	 * @var array
	 */
	private $_path = array();

	/**
	 * 配置文件列表
	 * @var array
	 */
	private $_file = array();

	/**
	 * 配置数据列表
	 * @var array
	 */
	private $_cache = array();

	/**
	 * 加载配置文件
	 * @param  string|array $config 配置文件名称
	 * @return object         [description]
	 */
	public function __construct($paths = null) {
		if (is_null($paths)) {
			$this->_path[] = CFGROOT . DS;
			$files = glob($this->_path.'*.php');

			foreach ($files as $file) {
				$path = pathinfo($file);
				$this->_file[] = $path['basename'];
			}
		} else {
			foreach ($paths as $path) {
				
			}
		}
	}

	/**
	 * 获取配置数据
	 * @param  string $key     配置名称
	 * @param  string $default 配置默认值
	 * @return mixed          获取到返回配置值，否则返回默认值
	 */
	public function get($key, $default = null) {
		if (isset($this->_cache[$key])) {
			return $this->_cache[$key];
		}

		$parsed = explode('.', $key);
		$result = $this->_cache;

		while ($parsed) {
			$next = array_shift($parsed);

			if (isset($result[$next])) {
				$result = $result[$next];
			} else {
				return $default;
			}
		}

		return $result;
	}

	/**
	 * 写入配置数据
	 * @param string  $key   配置名称
	 * @param boolean $value 配置值
	 */
	public function set($key, $value = false) {
		$parsed = explode('.', $key);
		$result = &$this->_cache;

		while (1 < count($parsed)) {
			$next = array_shift($parsed);

			if (!isset($result[$next]) || !is_array($result[$next])) {
				$result[$next] = [];
			}

			$result = &$result[$next];
		}

		$result[array_shift($parsed)] = $value;		
	}

}
