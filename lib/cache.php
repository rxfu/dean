<?php

/**
 * 缓存类
 */
class Cache {

	/**
	 * Cache路径
	 * @var string
	 */
	public $_path = CACHE;

	/**
	 * Cache文件扩展名
	 * @var string
	 */
	private $_extension = null;

	/**
	 * 保存Cache
	 * @param  string $key  Cache名称
	 * @param  string $data Cache数据
	 * @return void
	 */
	public function store($key, $data) {
		$filename = $this->getFilename($key);
		file_put_contents($filename, $data);
		return $filename;
	}

	/**
	 * 获取Cache
	 * @param  string $key Cache名称
	 * @return string      Cache数据
	 */
	public function fetch($key) {
		if ($this->isCached($key)) {
			$filename = $this->getFilename($key);
			return $filename;
		}

		return false;
	}

	/**
	 * 检测是否有缓存
	 * @param  string  $key Cache名称
	 * @return boolean      存在为TRUE，否则为FALSE
	 */
	public function isCached($key) {
		$filename = $this->getFilename($key);
		return file_exists($filename);
	}

	/**
	 * 生成Cache文件名
	 * @param  string $key Cache名称
	 * @return string      Cache文件名
	 */
	public function getFilename($key) {
		$filename    = md5($key);
		$filename    = $this->_path . DS . $filename;

		if (!is_null($this->_extension)) {
			$filename .= '.' . $this->_extension;
		}

		return $filename;
	}
}