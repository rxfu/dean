<?php

/**
 * 课程表模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class ScheduleModel extends StudentAdminModel {

	/**
	 * 获取课程表信息
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $sno  学号
	 * @return mixed       成功返回课程表信息，否则返回FALSE
	 */
	public function getTimetable($year, $term, $sno) {
		$sql  = 'SELECT * FROM v_xk_xskcb WHERE nd = ? AND xq = ? AND xh = ?';
		$data = $this->db->getAll($sql, array($year, $term, $sno));

		return has($data) ? $data : false;
	}

	/**
	 * 获取专业课程信息
	 * @param  string $year       年度
	 * @param  string $term       学期
	 * @param  string $grade      年级
	 * @param  string $speciality 专业号
	 * @return mixed             成功返回专业课程信息，否则返回FALSE
	 */
	public function getSpecialCourses($year, $term, $grade, $speciality) {
		$sql  = 'SELECT DISTINCT kch, kcmc, kcywmc, pt, xz, xs, xf FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND nj = ? AND zyh = ?';
		$data = $this->db->getAll($sql, array($year, $term, $grade, $speciality));

		return has($data) ? $data : false;
	}

}