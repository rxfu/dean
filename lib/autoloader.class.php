<?php

/**
 * 自动加载类
 */
class Autoloader {

	/**
	 * 自动加载类文件
	 * @param  string $className 类名
	 * @return NULL
	 */
	public static function autoload($className) {
		$className = ltrim($className, '\\');

		$pos = strrpos($className, 'Controller');
		if (false !== $pos && 0 != $pos) {
			$fileName = APPROOT . DIRECTORY_SEPARATOR . $className . '.php';
		} else {
			$fileName = __DIR__ . DIRECTORY_SEPARATOR . $className . '.class.php';
		}

		if (file_exists($fileName)) {
			require $fileName;
		}
	}

	/**
	 * 注册autoloader
	 * @return NULL
	 */
	public static function register() {
		spl_autoload_register('Autoloader::autoload');
	}
}