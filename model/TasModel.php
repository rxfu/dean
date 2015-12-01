<?php

/**
 * 教师评学模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class TasModel extends TeacherAdminModel {

	/**
	 * 保存教师评学数据
	 * @param  string $year    年度
	 * @param  string $term    学期
	 * @param  string $tno     教师工号
	 * @param  string $cno     12位课程序号
	 * @param  string $college 学院号
	 * @param  string $special 专业号
	 * @param  string $grade   年级
	 * @param  string $scores  评学分数
	 * @return boolean          成功返回true，否则返回false
	 */
	public function save($year, $term, $tno, $cno, $college, $special, $grade, $scores) {
		$data['nd']   = $year;
		$data['xq']   = $term;
		$data['jsgh'] = $tno;
		$data['kcxh'] = $cno;
		$data['kch']  = substr($cno, 2, 8);
		$data['kkxy'] = $college;
		$data['zy']   = $special;
		$data['nj']   = $grade;

		$inserted = false;
		foreach ($scores as $score) {
			$data['pjbz_id']    = $score['pjbz'];
			$data['fz']         = $score['fz'];
			$data['updated_at'] = $data['created_at'] = date('Y-m-d H:i:s');
			$inserted           = $this->db->insertRecord('t_px_pfjg', $data);
		}

		return $inserted;
	}

	/**
	 * 列出教师评学标准数据
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $jsgh 教师工号
	 * @param  string $cno  12位课程序号
	 * @return mixed       成功返回评学数据，否则返回false
	 */
	public function listStandards($year, $term, $jsgh, $cno) {
		$sql  = 'SELECT a.id AS pjbz_id, a.xh AS xh, a.mc AS bzmc, b.mc AS zbmc, a.fz AS zgfz, c.fz FROM t_px_pjbz a INNER JOIN t_px_pjzb b ON b.id = a.pjzb_id LEFT JOIN t_px_pfjg c ON c.pjbz_id = a.id AND c.nd = ? AND c.xq = ? AND c.jsgh = ? AND c.kcxh = ? WHERE a.zt = ?';
		$data = $this->db->getAll($sql, array($year, $term, $jsgh, $cno, ENABLE));

		return has($data) ? $data : false;
	}

	/**
	 * 获取课程信息
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno  12位课程序号
	 * @return mixed       成功返回课程信息，否则返回false
	 */
	public function getCourseInfo($year, $term, $cno) {
		$sql  = 'SELECT DISTINCT(b.jsgh), a.nd, a.xq, a.kcxh, c.kcmc, a.nj, a.zy, a.kkxy FROM t_pk_kczy a INNER JOIN t_pk_jxrw b ON b.kcxh = a.kcxh AND b.nd = a.nd AND b.xq = a.xq INNER JOIN t_jx_kc c ON c.kch = b.kch WHERE a.nd = ? AND a.xq = ? AND a.kcxh = ?';
		$data = $this->db->getRow($sql, array($year, $term, $cno));

		return has($data) ? $data : false;
	}
}