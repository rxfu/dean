<?php

/**
 * 配置类
 */
final class Config {

	use Singleton;

	/**
	 * 配置文件列表
	 * @var array
	 */
	private static $_paths = array();

	/**
	 * 配置数据列表
	 * @var array
	 */
	public static $_cache = array();

	/**
	 * 构造函数
	 * @param  string|array $paths 配置文件路径
	 * @return void
	 */
	public function __construct($paths = null) {
		if (is_null($paths)) {
			$paths = glob(CFGROOT . DS . '*.php');
		}

		$env   = include ROOT . DS . 'environment.php';
		$paths = is_array($paths) ? $paths : array($paths);
		$paths = array_merge($paths, glob(CFGROOT . DS . $env['env'] . DS . '*.php'));

		self::load($paths);
	}

	/**
	 * 加载配置文件
	 * @param  string|array $paths 配置文件名称
	 * @return void
	 */
	public static function load($paths) {
		$paths = is_string($paths) ? array($paths) : $paths;

		foreach ($paths as $path) {
			$info = pathinfo($path);
			$ext  = strtolower($info['extension']);

			if (isset($ext) && 'php' === $ext) {
				if (file_exists($path)) {
					self::$_paths[] = $path;
				}
			}
		}

		if (!empty(self::$_paths)) {
			foreach (self::$_paths as $path) {
				$config       = include $path;
				self::$_cache = array_merge(self::$_cache, $config);
			}
		}
	}

	/**
	 * 获取配置数据
	 * @param  string $key     配置名称
	 * @param  string $default 配置默认值
	 * @return mixed          获取到返回配置值，否则返回默认值
	 */
	public static function get($key, $default = null) {
		if (isset(self::$_cache[$key])) {
			return self::$_cache[$key];
		}

		$parsed = explode('.', $key);
		$result = self::$_cache;

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
	public static function set($key, $value = false) {
		$parsed = explode('.', $key);
		$result = &self::$_cache;

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
