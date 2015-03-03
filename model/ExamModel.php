<?php

/**
 * 考试模型类
 */
class ExamModel extends Model {

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

		return EXAM_PASS == $registered ? true : false;
	}
}