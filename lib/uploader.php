<?php

/**
 * 文件上传类
 */
class Uploader {

	/**
	 * 临时文件名
	 * @var string
	 */
	private $_tmpName = null;

	/**
	 * 目标路径
	 * @var string
	 */
	private $_destination = null;

	/**
	 * 新文件名
	 * @var string
	 */
	private $_filename = null;

	/**
	 * 上传文件大小
	 * @var integer
	 */
	private $_maxFileSize = 0;

	/**
	 * MIME类型
	 * @var array
	 */
	private $_mimes = array();

	/**
	 * 文件信息
	 * @var array
	 */
	private $_file = array();

	/**
	 * 错误信息
	 * @var array
	 */
	private $_errors = array();

	/**
	 * 文件上传类构造函数
	 * @param string $destination 目标路径
	 */
	public function __construct($destination) {
		ini_set('file_uploads', FILE_UPLOADS);
		ini_set('max_input_time', MAX_INPUT_TIME);
		ini_set('max_execution_time', MAX_EXECUTION_TIME);
		ini_set('post_max_size', POST_MAX_SIZE . 'M');
		ini_set('upload_max_filesize', UPLOAD_MAX_FILESIZE . 'M');
		ini_set('memory_limit', MEMORY_LIMIT . 'M');

		if (!$this->_setDestination($destination)) {
			$this->setError('创建目标路径失败');
		}
	}

	/**
	 * 设置目标路径
	 * @param string $destination 目标路径
	 */
	private function _setDestination($destination) {
		$this->_destination = $destination;

		if (!$this->_isExistDestination()) {
			$this->_createDestination();
		}
	}

	/**
	 * 创建目标路径
	 * @return boolean 成功为TRUE，失败为FALSE
	 */
	private function _createDestination() {
		return mkdir($this->_destination, 750, true);
	}

	/**
	 * 检测目标路径是否可写
	 * @return boolean 可写为TRUE，不可写为FALSE
	 */
	private function _isExistDestination() {
		return is_writable($this->_destination);
	}

	/**
	 * 设置新文件名
	 * @param string $filename 新文件名
	 */
	public function setFilename($filename) {
		$this->_filename = $filename;
	}

	/**
	 * 获取新文件名
	 * @return string 新文件名
	 */
	public function getFilename() {
		return $this->_filename;
	}

	/**
	 * 设置错误信息
	 * @param string $message 错误信息
	 */
	public function setError($message) {
		$this->_errors[] = $message;
	}

	/**
	 * 获取错误信息
	 * @return array 错误信息
	 */
	public function getErrors() {
		return $this->_errors;
	}

	/**
	 * 上传文件
	 * @return array 上传后文件
	 */
	public function upload() {
		if ($this->isValid()) {
			if (isEmpty($this->_filename)) {
				$this->createNewFilename();
			}

			$this->_file['filename'] = $this->_filename;
			$this->_file['path']     = $this->_destination . DS . $this->_filename . $this->_file['extension'];

			$status = $this->_file['error'];
			if (0 < $status) {
				$this->setError('上传文件失败');
				return;
			}

			$status = $this->save();
			if (!$status) {
				$this->setError('保存文件失败');
				return;
			}
		}

		return $this->_file;
	}

	/**
	 * 检查文件的合法性
	 * @return boolean 合法为TRUE，非法为FALSE
	 */
	public function isValid() {
		if ($this->_isAllowedMimeTypes()) {
			if ($this->_isAllowedFileSize()) {
				return true;
			}
		}

		$this->_file['errors'] = $this->getErrors();
		return false;
	}

	/**
	 * 保存文件
	 * @return boolean 保存成功为TRUE，失败为FALSE
	 */
	protected function save() {
		return move_uploaded_file($this->_tmpName, $this->_file['path']);
	}

	/**
	 * 保存文件信息
	 * @param  array $file 文件信息数组
	 * @return void
	 */
	public function setFile($file) {
		$this->_file = $file;

		$this->_tmpName           = $file['tmp_name'];
		$temp                     = explode('.', $this->_file['name']);
		$this->_file['extension'] = strtolower(end($temp));
	}

	/**
	 * 创建随机文件名
	 * @return void
	 */
	protected function createNewFilename() {
		$filename = sha1(mt_rand(1, 9999) . $this->_destination . uniqid()) . time();
		$this->setFilename($filename);
	}

	/**
	 * 获取临时文件名
	 * @return string 临时文件名
	 */
	protected function getTmpName() {
		return $this->_tmpName;
	}

	/**
	 * 设置允许MIME类型
	 * @param string $mimes MIME类型
	 */
	public function setAllowedMimeTypes($mimes) {
		$this->_mimes = $mimes;
	}

	/**
	 * 设置上传文件大小限制
	 * @param int $size 上传文件大小
	 */
	public function setMaxFileSize($size) {
		$this->_maxFileSize = $size;
	}

	/**
	 * 检测文件是否为有效文件类型
	 * @return boolean 符合文件类型为TRUE，不符合为FALSE
	 */
	private function _isAllowedMimeTypes() {
		if (!isEmpty($this->_mimes)) {
			if (!in_array($this->_file['type'], $this->_mimes)) {
				$this->setError('文件类型无效，请上传有效文件类型');
				return false;
			}
		}

		return true;
	}

	/**
	 * 检测文件是否超过大小限制
	 * @return boolean 未超过大小为TRUE，超过为FALSE
	 */
	private function _isAllowedFileSize() {
		if (!isEmpty($this->_maxFileSize)) {
			$filesize = byteToMb($this->_file['size']);
			if ($this->_maxFileSize <= $filesize) {
				$this->setError('文件超过限制大小' . $this->_maxFileSize . 'MB');
				return false;
			}
		}

		return true;
	}

}
