<?php

/**
 * 学生模型类
 */
class StudentModel extends StudentAdminModel {

	/**
	 * 判断当前学生是否欠费
	 *
	 * @return boolean     欠费为TRUE，未欠费为FALSE
	 */
	protected function isUnpaid() {
		$sql  = 'SELECT COUNT(*) FROM t_xk_xsqf WHERE xh = ?';
		$has = $this->db->getColumn($sql, $this->session->get('username'));

		return 0 < $has;
	}

	/**
	 * 判断学生是否已经上传照片
	 * @param  string $file 文件名
	 * @return boolean 已经上传为TRUE，否则为FALSE
	 */
	public function isUploadedPortrait($file) {
		$path = PORTRAIT . DS . $file . '.jpg';
		return file_exists($path);
	}

	/**
	 * 检测是否新生
	 * @param  string  $sno 学号
	 * @return boolean      是新生为TRUE，否则为FALSE
	 */
	public function isFresh($sno) {
		$sql = 'SELECT count(*) FROM t_xs_zxs WHERE age(rxrq) < ? AND xh = ? ';
		$count = $this->db->geColumn($sql, array('1 year', $sno));

		return !isEmpty($data) && is_array($data);
	}

}