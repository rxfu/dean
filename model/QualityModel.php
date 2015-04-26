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
	 * @param  string $status 评教状态
	 * @param string $cno 12位课程序号
	 * @return mixed        成功返回可评教课程信息，否则返回FALSE
	 */
	public function getCourses($year, $term, $sno, $status, $cno = null) {
		if (Config::get('quality.assessed') == $status) {
			$sql = 'SELECT * FROM v_xk_xskcb a INNER JOIN t_zl_xspf b ON b.nd = a.nd AND b.xq = a.xq AND b.xh = a.xh WHERE a.nd = ? AND a.xq = ? AND a.xh = ?';
		} elseif (Config::get('quality.assessing') == $status) {
			$sql = 'SELECT * FROM v_xk_xskcb a LEFT JOIN t_zl_xspf b ON b.nd = a.nd AND b.xq = a.xq AND b.xh = a.xh WHERE a.nd = ? AND a.xq = ? AND a.xh = ? AND b.kcxh IS NULL';
		}

		if (!is_null($cno)) {
			$sql .= ' AND a.kcxh = ?';
		}
		$data = $this->db->getAll($sql);

		return has($data) ? $data : false;
	}

	/**
	 * 获取评教指标
	 * @return mixed 成功返回评教指标数据，否则返回FALSE
	 */
	public function getIndexes() {
		$sql  = 'SELECT a.zb_id, a.zb_mc, b.ejzb_id, b.ejzb_mc FROM t_zb_yjzb a INNER JOIN t_zb_ejzb b ON b.zb_id = a.zb_id ORDER BY a.zb_id';
		$data = $this->db->getAll($sql);

		return has($data) ? $data : false;
	}

	/**
	 * 获取评教等级
	 * @return mixed 成功返回评教等级数据，否则返回FALSE
	 */
	public function getRanks() {
		$sql  = 'SELECT rank_id, rank_mc, rank_fs FROM t_zl_rank';
		$data = $this->db->getAll($sql);

		return has($data) ? $data : false;
	}

	/**
	 * 保存学生评教分数
	 * @param  string $year   年度
	 * @param  string $term   学期
	 * @param  string $sno    学号
	 * @param  string $cno    12位课程序号
	 * @param  string $course 8位课程号
	 * @param  string $index  指标代码
	 * @param  string $score  评教等级
	 * @return mixed         成功返回TRUE，否则返回FALSE
	 */
	public function saveScore($year, $term, $sno, $cno, $course, $index, $score) {
		$data['c_nd']    = $year;
		$data['c_xq']    = $term;
		$data['c_xh']    = $sno;
		$data['c_kcxh']  = $cno;
		$data['c_kch']   = $course;
		$data['c_xm']    = $index;
		$data['rank_id'] = $score;

		$inserted = $this->db->insertRecord('t_zl_xspf', $data);

		return $inserted;
	}

	/**
	 * 保存学生评语
	 * @param  string $year        年度
	 * @param  string $term        学期
	 * @param  string $sno         学号
	 * @param  string $cno         12位课程序号
	 * @param  string $course      8位课程号
	 * @param  string $advantage   优点
	 * @param  string $shortcoming 缺点
	 * @param  string $word        一句话评语
	 * @return mixed              成功返回TRUE，否则为FALSE
	 */
	public function saveComment($year, $term, $sno, $cno, $course, $advantage, $shortcoming, $word) {
		$data['c_nd']   = $year;
		$data['c_xq']   = $term;
		$data['c_xh']   = $sno;
		$data['c_kcxh'] = $cno;
		$data['c_kch']  = $course;
		$data['c_yd']   = $advantage;
		$data['c_qd']   = $shortcoming;
		$data['c_one']  = $word;

		$inserted = $this->db->insertRecord('t_zl_xspy', $data);

		return $inserted;
	}
}