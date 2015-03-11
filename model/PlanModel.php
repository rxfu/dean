<?php

/**
 * 教学计划模型类
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

		return has($data) ? $data : false;
	}

	/**
	 * 获取课程信息
	 * @return mixed 成功返回课程信息，否则返回FALSE
	 */
	public function getCourses() {
		$sql  = 'SELECT * FROM t_jx_kc_xx';
		$data = $this->db->getAll($sql);

		return has($data) ? $data : false;
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

		return has($data) ? $data : false;
	}

}