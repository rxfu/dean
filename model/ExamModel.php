<?php

/**
 * 考试模型类
 */
class ExamModel extends StudentAdminModel {

	/**
	 * 检测是否已经报名
	 * @param  string  $sno  学号
	 * @param  string  $type 考试类型
	 * @param  string  $date 考试时间
	 * @return boolean       已经报名为TRUE，未报名为FALSE
	 */
	public function isRegistered($sno, $type, $date) {
		$sql        = 'SELECT clbz FROM t_ks_qtksbm WHERE xh = ? AND kslx = ? AND kssj = ?';
		$registered = $this->db->getColumn($sql, array($sno, $type, $date));

		return isEmpty($registered) ? false : true;
	}

	/**
	 * 检测是否限制报名
	 * @param  string  $type       考试类型
	 * @param  string  $speciality 专业
	 * @param  string  $college    学院
	 * @return boolean             允许报名为ENABLE，禁止报名为DISABLE
	 */
	public function isAllowedRegister($type, $speciality, $college) {
		$sql    = 'SELECT zt FROM t_ks_bmzyxz WHERE kslx = ? AND zy = ? AND xy = ?';
		$status = $this->db->getColumn($sql, array($type, $specility, $college));

		return has($status) ? $status : ENABLE;
	}

	/**
	 * 检测学生相应的考试类型是否及格
	 * @param  string  $sno  学号
	 * @param  string  $type 考试类型
	 * @return boolean       及格为TRUE，不及格为FALSE
	 */
	public function isPassed($sno, $type) {
		$sql    = 'SELECT c_cj FROM t_cj_qtkscj WHERE c_xh = ? AND c_kslx = ?';
		$scores = $this->db->getAll($sql, array($sno, $type));

		$sql      = 'SELECT jgx FROM t_cj_kslxdm WHERE c_kslx = ?';
		$passline = $this->db->getColumn($sql, array($type));

		return $scores >= $passline;
	}
}