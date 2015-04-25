<?php

/**
 * 教师课程表模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
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
	public function listStudents($year, $term, $tno, $cno) {
		$sql  = 'SELECT DISTINCT a.xh, b.xm, a.kcxh, a.kcmc FROM v_xk_xskcb a INNER JOIN t_xs_zxs b ON b.xh = a.xh INNER JOIN t_pk_jxrw c ON c.nd = a.nd AND c.xq = a.xq AND c.kcxh = a.kcxh WHERE a.nd = ? AND a.xq = ? AND c.jsgh = ? AND a.kcxh = ? ORDER BY a.xh';
		$data = $this->db->getAll($sql, array($year, $term, $tno, $cno));

		return has($data) ? $data : false;
	}

}