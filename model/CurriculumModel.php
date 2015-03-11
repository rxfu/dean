<?php

/**
 * 教师课程表模型类
 */
class CurriculumModel extends TeacherAdminModel {

	/**
	 * 获取教师上课课程列表
	 * @param  string $tno 教师工号
	 * @return mixed      成功返回教师上课课程列表，否则返回FALSE
	 */
	public function listCourses($tno) {
		$sql  = 'SELECT * FROM v_pk_jskcb WHERE jsgh = ? ORDER BY nd DESC, xq DESC, kcxh, ksz, zc, ksj';
		$data = $this->db->getAll($sql, $tno);

		return has($data) ? $data : false;
	}

	/**
	 * 获取教师所上课程学生
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $tno  教师工号
	 * @param  string $cno  12位课程序号
	 * @return mixed       成功返回教师所上课程学生列表，否则返回FALSE
	 */
	public function listStudent($year, $term, $tno, $cno) {
		$sql  = 'SELECT * FROM v_xk_xskcb WHERE nd = ? AND xq = ? AND jsgh = ? AND kcxh = ? ORDER BY xh';
		$data = $this->db->getAll($sql, array($year, $term, $tno, $cno));

		return has($data) ? $data : false;
	}

}