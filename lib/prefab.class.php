<?php

/**
 * 抽象预制类
 */
abstract class Prefab {

	/**
	 * 保存类的唯一实例
	 * @var array
	 */
	private static $_instances = array();

	/**
	 * 私有化构造方法，保证外界不能实例化
	 */
	private function __construct() {}

	/**
	 * 覆盖__clone()方法，禁止克隆
	 */
	private function __clone() {}

	/**
	 * 获取类的唯一实例
	 * @return object 类实例
	 */
	public static function getInstance() {
		$className = get_called_class();
		if (!self::_exists($className)) {
			$ref  = new ReflectionClass($className);
			$args = func_get_args();
			self::_set($className, $args ? $ref->newInstanceArgs($args) : new $className);
			self::_get($className)->_init();
		}

		return self::_get($className);
	}

	/**
	 * 判断类是否已经实例化
	 * @param  string $key 类名
	 * @return boolean      已经实例化为TRUE，未实例化为FALSE
	 */
	private static function _exists($key) {
		return isset(self::$_instances[$key]);
	}

	/**
	 * 向实例列表中添加实例
	 * @param string $key 类名
	 * @param object $obj 类实例
	 */
	private static function _set($key, $obj) {
		self::$_instances[$key] = $obj;
	}

	/**
	 * 获取类实例
	 * @param  string $key 类名
	 * @return object      类实例
	 */
	private static function _get($key) {
		return self::$_instances[$key];
	}

	/**
	 * 初始化类方法
	 * @return NULL
	 */
	protected function _init() {}
}