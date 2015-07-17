<?php

/**
 * 教师成绩模型类
 * 
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class ScoreModel extends TeacherAdminModel {

	/**
	 * 判断是否允许录入成绩
	 * @return boolean 允许为TRUE，禁止为FALSE
	 */
	public function isOpen() {
		return ENABLE == Setting::get('CJ_WEB_KG') ? true : false;
	}

	/**
	 * 获取成绩方式
	 * @param  string $gid 成绩方式代码
	 * @return mixed        获取成功返回成绩方式，否则返回FALSE
	 */
	public function getRatio($gid) {
		$sql   = 'SELECT * FROM t_jx_cjfs WHERE fs = ?';
		$modes = $this->db->getAll($sql, array($gid));
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
	 * 按年度按学期列出成绩单
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $tno 教师工号
	 * @return mixed       成功返回成绩单列表，否则返回FALSE
	 */
	public function listCourses($year, $term, $tno) {
		$sql  = 'SELECT DISTINCT kcxh, kcmc FROM v_cj_xsgccj WHERE nd = ? AND xq = ? AND jsgh = ? ORDER BY kcxh';
		$data = $this->db->getAll($sql, array($year, $term, $tno));

		return has($data) ? $data : false;
	}

	/**
	 * 获取课程信息
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno  12位课程序号
	 * @return mixed       成功返回课程信息，否则返回FALSE
	 */
	public function getCourse($year, $term, $cno) {
		$sql  = 'SELECT kcxh, kcmc, kkxy, nj, zy FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		$data = $this->db->getRow($sql, array($year, $term, $cno));

		return has($data) ? $data : false;
	}

	/**
	 * 获取所上课程学生
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno  12位课程序号
	 * @param  string $tno 教师工号
	 * @return mixed       成功返回学生列表，否则返回FALSE
	 */
	public function getStudents($year, $term, $cno, $tno) {
		$sql  = 'SELECT * FROM v_cj_xscjlr WHERE nd = ? AND xq = ? AND kcxh = ? AND jsgh = ? ORDER BY xh';
		$data = $this->db->getAll($sql, array($year, $term, $cno, $tno));

		return has($data) ? $data : false;
	}

	/**
	 * 获取课程考试成绩
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno  12位课程序号
	 * @return mixed       成功返回课程考试成绩，否则返回FALSE
	 */
	public function getReport($year, $term, $cno) {
		$sql  = 'SELECT * FROM v_cj_xsgccj WHERE nd = ? AND xq = ? AND kcxh = ? ORDER BY xh';
		$data = $this->db->getAll($sql, array($year, $term, $cno));

		return has($data) ? $data : false;
	}

	/**
	 * 获取考试状态列表
	 * @return mixed  成功返回考试状态列表，否则返回FALSE
	 */
	public function getStatuses() {
		$sql  = 'SELECT * FROM t_cj_kszt ORDER BY dm';
		$data = $this->db->getAll($sql);

		return has($data) ? $data : false;
	}

	/**
	 * 获取学生课程考试成绩
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $sno  学号
	 * @param  string $cno  12位课程序号
	 * @return mixed       成功返回学生考试成绩，否则返回FALSE
	 */
	public function getScore($year, $term, $sno, $cno) {
		$sql  = 'SELECT * FROM t_cj_web WHERE nd = ? AND xq = ? AND xh = ? AND kcxh = ?';
		$data = $this->db->getRow($sql, array($year, $term, $sno, $cno));

		return has($data) ? $data : false;
	}

	/**
	 * 录入学生成绩
	 * @param  string $year  年度
	 * @param  string $term  学期
	 * @param  string $sno   学号
	 * @param  string $cno   12位课程序号
	 * @param  string $gid   成绩方式代码
	 * @param  integer $score 成绩
	 * @param  string $total 总评成绩
	 * @return mixed        成功返回总评成绩，否额返回FALSE
	 */
	public function enterScore($year, $term, $sno, $cno, $gid, $score, $total) {
		$sql     = 'UPDATE t_cj_web SET cj' . $gid . ' = ?, zpcj = ? WHERE nd = ? AND xq = ? AND xh = ? AND kcxh = ?';
		$entered = $this->db->update($sql, array($score, $total, $year, $term, $sno, $cno));

		if ($entered) {
			$sql   = 'SELECT zpcj FROM t_cj_web WHERE nd = ? AND xq = ? AND xh = ? AND kcxh = ? ';
			$total = $this->db->getColumn($sql, array($year, $term, $sno, $cno));
		}

		return isset($total) ? $total : false;
	}

	/**
	 * 修改学生考试状态
	 * @param  string $year   年度
	 * @param  string $term   学期
	 * @param  string $sno    学号
	 * @param  string $cno    12位课程序号
	 * @param  string $status 考试状态代码
	 * @return boolean         修改成功返回TRUE，否则返回FALSE
	 */
	public function modifyStatus($year, $term, $sno, $cno, $status) {
		$sql      = 'UPDATE t_cj_web SET kszt = ? WHERE nd = ? AND xq = ? AND xh = ? AND kcxh = ?';
		$modified = $this->db->update($sql, array($status, $year, $term, $sno, $cno));

		return $modified ? true : false;
	}

	/**
	 * 确认成绩
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno  12位课程序号
	 * @return boolean       确认成功返回TRUE，否则返回FALSE
	 */
	public function confirmScore($year, $term, $cno) {
		$sql       = 'UPDATE t_cj_web SET tjzt = ? WHERE nd = ? AND xq = ? AND kcxh = ?';
		$confirmed = $this->db->update($sql, array(Config::get('score.submit.committed'), $year, $term, $cno));

		return $confirmed ? true : false;
	}

}
