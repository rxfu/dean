<?php

/**
 * 单例类
 */
trait Singleton {

	/**
	 * 保存类的唯一实例
	 * @var object
	 */
	private static $_instance;

	/**
	 * 私有化构造方法
	 */
	private function __construct() {
		$this->init();
	}

	/**
	 * 覆盖__clone()方法，禁止克隆
	 * @return void
	 */
	final private function __clone() {
		trigger_error('Cloning ' . __CLASS__ . ' is not allowed.', E_USER_ERROR);
	}

	/**
	 * 覆盖__wakeup()方法，禁止序列化
	 */
	final private function __wakeup() {
		trigger_error('Unserialize ' . __CLASS__ . ' is not allowed.', E_USER_ERROR);
	}

	/**
	 * 获取类的唯一实例
	 * @return object 类实例
	 */
	public static function getInstance() {
		if (!isset(self::$_instance)) {
			$className       = get_called_class();
			$ref             = new ReflectionClass($className);
			$args            = func_get_args();
			self::$_instance = $args ? $ref->newInstanceArgs($args) : new $className;
		}

		return self::$_instance;
	}

	/**
	 * 初始化类方法
	 * @return void
	 */
	protected function init() {}
}