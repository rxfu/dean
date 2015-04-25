<?php

/**
 * 教学质量监控模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class QualityModel extends StudentAdminModel {

	/**
	 * 判断评教系统是否开放
	 * @return boolean 开放为TRUE，否则为FALSE
	 */
	public function isOpen() {
		$sql  = 'SELECT * FROM t_xt_jxpg';
		$data = $this->db->getColumn('c_flag');

		return ENABLE == $data;
	}

	/**
	 * 获取可评教课程
	 * @param  string  $year 年度
	 * @param  string  $term 学期
	 * @param  string  $sno  学号
	 * @param  boolean $flag 评教状态，已评教为TRUE，未评教为FALSE
	 * @return mixed        成功返回可评教课程信息，否则返回FALSE
	 */
	public function getCourses($year, $term, $sno, $flag = true) {
		if (true === $flag) {
			$sql = 'SELECT * FROM v_xk_xskcb a INNER JOIN t_zl_xspf b ON b.nd = a.nd AND b.xq = a.xq AND b.xh = a.xh WHERE a.nd = ? AND a.xq = ? AND a.xh = ?';
		} elseif (false === $flag) {
			$sql = 'SELECT * FROM v_xk_xskcb a LEFT JOIN t_zl_xspf b ON b.nd = a.nd AND b.xq = a.xq AND b.xh = a.xh WHERE a.nd = ? AND a.xq = ? AND a.xh = ? AND b.kcxh IS NULL';
		} else {
			$sql = 'SELECT * FROM v_xk_xskcb WHERE nd = ? AND xq = ? AND xh = ?';
		}
		$data = $this->db->getAll($sql);

		return has($data) ? $data : false;
	}
}