<?php

/**
 * 学生模型类
 */
class StudentModel extends Model {

	/**
	 * 判断学生是否已经上传照片
	 * @param  string $file 文件名
	 * @return boolean 已经上传为TRUE，否则为FALSE
	 */
	public function isUploadedPortrait($file) {
		$path = PORTRAIT . DS . $file . '.jpg';
		return file_exists($path);
	}

}