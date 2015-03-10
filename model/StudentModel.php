<?php

/**
 * 学生模型类
 */
class StudentModel extends StudentAdminModel {

	/**
	 * 判断当前学生是否欠费
	 * @param  string $sno 学号
	 * @return boolean     欠费为TRUE，未欠费为FALSE
	 */
	public function isUnpaid($sno) {
		$sql   = 'SELECT COUNT(*) FROM t_xk_xsqf WHERE xh = ?';
		$count = $this->db->getColumn($sql, $sno);

		return 0 < $count;
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
	 * 检测是否在校生
	 * @param  string  $sno 学号
	 * @return boolean      是在校生为TRUE，否则为FALSE
	 */
	public function isStudent($sno) {
		$sql   = 'SELECT COUNT(*) FROM t_xs_zxs WHERE xh = ? AND zjzt = ?';
		$count = $this->db->getColumn($sql, array($sno, Config::get('user.status')));

		return has($count) && 0 < $count;
	}

	/**
	 * 检测是否新生
	 * @param  string  $sno 学号
	 * @return boolean      是新生为TRUE，否则为FALSE
	 */
	public function isFresh($sno) {
		$sql   = 'SELECT COUNT(*) FROM t_xs_zxs WHERE xh = ? AND zjzt = ? AND age(rxrq) < ?';
		$count = $this->db->getColumn($sql, array($sno, Config::get('user.status'), '1 year'));

		return has($count) && 0 < $count;
	}

	/**
	 * 检测是否专升本学生
	 * @param  string  $sno 学号
	 * @return boolean      是专升本学生为TRUE，否则为FALSE
	 */
	public function isUndergraduate($sno) {
		$sql   = 'SELECT COUNT(*) FROM t_xz_zxs WHERE xh = ? AND zjzt = ? AND xz = ?';
		$count = $this->db->getColumn($sql, array($sno, Config::get('user.status'), '2'));

		return has($count) && 0 < $count;
	}

}