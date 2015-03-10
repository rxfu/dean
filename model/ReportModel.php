<?php

/**
 * 成绩单模型类
 */
class ReportModel extends StudentAdminModel {

	/**
	 * 获取成绩方式
	 * @param  string $grade 成绩方式代码
	 * @return mixed        获取成功返回成绩方式，否则返回FALSE
	 */
	public function getRatio($grade) {
		$modes = $this->db->searchRecord('t_jx_cjfs', array('fs' => $grade));
		if (is_array($modes)) {
			$ratios = array();
			foreach ($modes as $mode) {
				$ratios['name']              = $mode['khmc'];
				$ratios['mode'][$mode['id']] = array('idm' => $mode['idm'], 'bl' => $mode['bl'] / $mode['mf']);
			}

			return $ratios;
		}

		return false;
	}

	/**
	 * 获取学生所有成绩
	 * @param  string $sno 学号
	 * @return mixed      成功返回学生成绩，否则返回FALSE
	 */
	public function getReport($sno) {
		$sql  = 'SELECT * FROM v_cj_xscj WHERE xh = ? ORDER BY nd DESC, xq DESC';
		$data = $this->db->getAll($sql, $sno);

		return has($data) ? $data : false;
	}

	/**
	 * 获取学生过程成绩
	 * @param  string $sno 学号
	 * @param  string $cno 8位课程号
	 * @return mixed      成功返回学生过程成绩，否则返回FALSE
	 */
	public function getDetail($sno, $cno) {
		$sql  = 'SELECT * FROM v_cj_xsgccj WHERE xh = ? AND kch = ? AND tjzt = ? ORDER BY nd DESC, xq DESC';
		$data = $this->db->getAll($sql, array($sno, $cno, Config::get('score.dean_confirmed')));

		return has($data) ? $data : false;
	}

	/**
	 * 获取学生未确认成绩
	 * @param  string $sno 学号
	 * @return mixed      成功返回学生未确认成绩，否则返回FALSE
	 */
	public function getUnconfirmed($sno) {
		$sql  = 'SELECT * FROM v_cj_xsgccj WHERE xh = ? AND tjzt < ? ORDER BY nd DESC, xq DESC, kcxh';
		$data = $this->db->getAll($sql, array($sno, Config::get('score.dean_confirmed')));

		return has($data) ? $data : false;
	}

	/**
	 * 获取学生国家考试成绩
	 * @param  string $sno 学号
	 * @return mixed      成功返回学生国家考试成绩，否则返回FALSE
	 */
	public function getExamReport($sno) {
		$sql  = 'SELECT a.c_kslx, b.ksmc, a.c_cj, a.c_kssj FROM t_cj_qtkscj a LEFT JOIN t_cj_kslxdm b ON b.kslx = a.c_kslx WHERE a.c_xh = ? ORDER BY a.c_kslx, a.c_kssj DESC';
		$data = $this->db->getAll($sql, $sno);

		return has($data) ? $data : false;
	}

}