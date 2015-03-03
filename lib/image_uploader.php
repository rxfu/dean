<?php

/**
 * 图片上传模块
 */
class ImageUploader extends Uploader {

	/**
	 * 限制图片宽度
	 */
	private $_width = 0;

	/**
	 * 限制图片高度
	 */
	private $_height = 0;

	/**
	 * 设置图片宽度
	 * @param int $width 图片宽度
	 */
	public function setWidth($width) {
		$this->_width = $width;
	}

	/**
	 * 设置图片高度
	 * @param int $height 图片高度
	 */
	public function setHeight($height) {
		$this->_height = $height;
	}

	/**
	 * 保存图片
	 * @return boolean 保存成功为TRUR，失败为FALSE
	 */
	protected function save() {
		list($width, $height) = getimagesize($this->getTmpName());
		$scale                = $width / $height;

		if ($scale <= 0.74 && $scale >= 0.76) {
			$this->setError('照片比例不正确，请上传高宽比为4:3的照片');
			return;
		}

		$dImage = imagecreatetruecolor($this->_width, $this->_height) or die('Cannot Initialize new GD image stream');
		$image  = imagecreatefromjpeg($this->getTmpName());

		imagecopyresampled($dImage, $image, 0, 0, 0, 0, $this->_width, $this->_height, $width, $height);
		$status = imagejpeg($dImage, PORTRAIT . DS . $this->getFilename() . '.jpg', 100);

		imagedestroy($dImage);
		imagedestroy($image);

		return $status;
	}
}