<?php

/**
 * 教学计划模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class PlanModel extends StudentAdminModel {

	/**
	 * 获取教学计划
	 * @param  string $grade      年级
	 * @param  string $speciality 专业
	 * @param  string $season     招生季节
	 * @return mixed             成功返回教学计划，否则返回FALSE
	 */
	public function getPlan($grade, $speciality, $season) {
		$sql  = 'SELECT * FROM v_xk_jxjh WHERE nj = ? AND zy = ? AND zsjj = ?';
		$data = $this->db->getAll($sql, array($grade, $speciality, $season));

		return has($data) ? $data : array();
	}

	/**
	 * 获取课程信息
	 * @return mixed 成功返回课程信息，否则返回FALSE
	 */
	public function getCourses() {
		$sql  = 'SELECT * FROM t_jx_kc_xx';
		$data = $this->db->getAll($sql);

		return has($data) ? $data : array();
	}

	/**
	 * 获取毕业要求
	 * @param  string $grade      年级
	 * @param  string $speciality 专业
	 * @param  string $season     招生季节
	 * @param  string $plan       计划
	 * @return mixed             成功返回毕业要求，否则返回FALSE
	 */
	public function getGraduation($grade, $speciality, $season, $plan) {
		$sql  = 'SELECT * FROM t_jx_byyq WHERE nj = ? AND zy = ? AND zsjj = ? AND byfa = ?';
		$data = $this->db->getAll($sql, array($grade, $speciality, $season, $plan));

		return has($data) ? $data : array();
	}

	/**
	 * 获取已选课程学分
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $sno  学号
	 * @return mixed       成功返回已选课程学分，否则返回FALSE
	 */
	public function getSelectedCredits($year, $term, $sno) {
		$sql  = 'SELECT pt, xz, SUM(xf) as xf FROM t_xk_xkxx WHERE nd = ? AND xq = ? AND xh = ? GROUP BY pt, xz';
		$data = $this->db->getAll($sql, array($year, $term, $sno));

		return has($data) ? $data : array();
	}

	/**
	 * 获取已修读学分
	 * @param  string $sno 学号
	 * @return mixed      成功返回已修读学分，否则返回FALSE
	 */
	public function getStudiedCredits($sno) {
		$sql  = 'SELECT pt, kcxz, SUM(xf) AS xf FROM t_cj_zxscj WHERE xh = ? GROUP BY pt, kcxz';
		$data = $this->db->getAll($sql, $sno);

		return has($data) ? $data : array();
	}

	/**
	 * 获取选修系列
	 * @return mixed  成功返回选修系列，否则返回空
	 */
	public function getElectives() {
		$sql  = 'SELECT * FROM t_jx_xxxl WHERE zt = ? ORDER BY dm';
		$data = $this->db->getAll($sql, ENABLE);

		return $data;
	}

	/**
	 * 获取当前学生教学计划
	 * @param  string $spno  专业号
	 * @param  string $grade 年级
	 * @param  string $season 招生季节
	 * @return mixed        教学计划
	 */
	public function getCoursesByStudent($spno, $grade, $season) {
		$sql  = 'SELECT kch, zxf FROM t_jx_jxjh WHERE zy = ? AND nj = ? AND zsjj = ? ORDER BY kch';
		$data = $this->db->getAll($sql, array($spno, $grade, $season));

		return $data;
	}

}