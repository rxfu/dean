<?php

/**
 * 教师模型类
 */
class TeacherModel extends TeacherAdminModel {

	/**
	 * 根据学号获取学生基本信息
	 * @param  string $tno 学号
	 * @return array     成功返回学生基本信息，否则返回FALSE
	 */
	public function getInfo($tno) {
		$sql  = 'SELECT * FROM v_pk_jsxx WHERE jsgh = ?';
		$data = $this->db->getRow($sql, $tno);

		return has($data) ? $data : false;
	}

	/**
	 * 获取教师详细信息
	 * @param  string $tno 教师工号
	 * @return array 成功返回教师详细信息，否则返回FALSE
	 */
	public function getProfile($tno) {
		$sql  = 'SELECT * FROM v_pk_jsxx WHERE jsgh = ?';
		$data = $this->db->getRow($sql, $tno);

		return has($data) ? $data : false;
	}

	/**
	 * 验证教师密码
	 * @param  string $tno 教师工号
	 * @return mixed      成功返回TRUE，否则返回FALSE
	 */
	public function validate($tno, $password) {
		$sql  = 'SELECT * FROM t_pk_js WHERE jsgh = ? AND mm = ? AND zt = ?';
		$data = $this->db->getRow($sql, array($tno, encrypt($password), ENABLE));

		return has($data) ? true : false;
	}

	/**
	 * 修改教师密码
	 * @param  string $tno      教师工号
	 * @param  string $password 密码
	 * @return boolean          成功返回TRUE，否则返回FALSE
	 */
	public function changePassword($tno, $password) {
		$sql     = 'UPDATE t_pk_js SET mm = ? WHERE jsgh = ?';
		$updated = $this->db->update($sql, array(encrypt($password), $tno));

		return $updated ? true : false;
	}

}