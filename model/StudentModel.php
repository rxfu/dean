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
	 * 检测是否允许照片上传
	 * @return boolean 允许上传为TRUE，否则为FALSE
	 */
	public function isAllowedUploadPortrait() {
		return ENABLE == Setting::get('KS_PHOHO_UP') ? true : false;
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
		$sql   = 'SELECT COUNT(*) FROM t_xs_zxs WHERE xh = ? AND xjzt = ?';
		$count = $this->db->getColumn($sql, array($sno, Config::get('user.status')));

		return has($count) && 0 < $count;
	}

	/**
	 * 检测是否新生
	 * @param  string  $sno 学号
	 * @return boolean      是新生为TRUE，否则为FALSE
	 */
	public function isFresh($sno) {
		$sql   = 'SELECT COUNT(*) FROM t_xs_zxs WHERE xh = ? AND xjzt = ? AND age(rxrq) < ?';
		$count = $this->db->getColumn($sql, array($sno, Config::get('user.status'), '1 year'));

		return has($count) && 0 < $count;
	}

	/**
	 * 检测是否专升本学生
	 * @param  string  $sno 学号
	 * @return boolean      是专升本学生为TRUE，否则为FALSE
	 */
	public function isUndergraduate($sno) {
		$sql   = 'SELECT COUNT(*) FROM t_xs_zxs WHERE xh = ? AND xjzt = ? AND xz = ?';
		$count = $this->db->getColumn($sql, array($sno, Config::get('user.status'), '2'));

		return has($count) && 0 < $count;
	}

	/**
	 * 根据学号获取学生基本信息
	 * @param  string $sno 学号
	 * @return array     成功返回学生基本信息，否则返回FALSE
	 */
	public function getInfo($sno) {
		$sql  = 'SELECT * FROM v_xk_xsjbxx WHERE xh = ?';
		$data = $this->db->getRow($sql, $sno);

		return has($data) ? $data : false;
	}

	/**
	 * 获取学生详细信息
	 * @param  string $sno 学号
	 * @return array 成功返回学生详细信息，否则返回FALSE
	 */
	public function getProfile($sno) {
		$sql  = 'SELECT * FROM v_xk_xsxx WHERE xh = ?';
		$data = $this->db->getRow($sql, $sno);

		return has($data) ? $data : false;
	}

	/**
	 * 验证学生密码
	 * @param  string $sno 学号
	 * @return mixed      成功返回TRUE，否则返回FALSE
	 */
	public function validate($sno, $password) {
		$sql  = 'SELECT * FROM t_xk_xsmm WHERE xh = ? AND mm = ?';
		$data = $this->db->getRow($sql, array($sno, encrypt($password)));

		return has($data) ? true : false;
	}

	/**
	 * 修改学生密码
	 * @param  string $sno      学号
	 * @param  string $password 密码
	 * @return boolean          成功返回TRUE，否则返回FALSE
	 */
	public function changePassword($sno, $password) {
		$sql     = 'UPDATE t_xk_xsmm SET mm = ? WHERE xh = ?';
		$updated = $this->db->update($sql, array(encrypt($password), $sno));

		if ($updated) {
			Logger::write(array('xh' => $sno, 'czlx' => Config::get('log.change_password')));
			return true;

		}

		return false;
	}

	/**
	 * 设置照片上传成功状态
	 * @param  string $sno 学号
	 * @return boolean      成功返回TRUE，否则返回FALSE
	 */
	public function setUploadedSuccess($sno) {
		$sql     = 'UPDATE t_xk_xsmm SET zpzt = ? WHERE xh = ?';
		$updated = $this->db->update($sql, array(Config::get('user.portrait.uploaded'), $sno));

		return $updated ? true : false;
	}

}