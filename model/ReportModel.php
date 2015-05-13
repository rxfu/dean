<?php

/**
 * 成绩单模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class ReportModel extends StudentAdminModel {

	/**
	 * 获取成绩方式
	 * @param  string $grade 成绩方式代码
	 * @return mixed        获取成功返回成绩方式，否则返回FALSE
	 */
	public function getRatio($grade) {
		$sql   = 'SELECT * FROM t_jx_cjfs WHERE fs = ?';
		$modes = $this->db->getAll($sql, array($grade));
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
		$data = $this->db->getAll($sql, array($sno, $cno, Config::get('score.submit.dean_confirmed')));

		return has($data) ? $data : false;
	}

	/**
	 * 获取学生未确认成绩
	 * @param  string $sno 学号
	 * @return mixed      成功返回学生未确认成绩，否则返回FALSE
	 */
	public function getUnconfirmed($sno) {
		$sql  = 'SELECT * FROM v_cj_xsgccj WHERE xh = ? AND tjzt < ? ORDER BY nd DESC, xq DESC, kcxh';
		$data = $this->db->getAll($sql, array($sno, Config::get('score.submit.dean_confirmed')));

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

	/**
	 * 课程学分转换申请
	 * @param  string $year      年度
	 * @param  string $term      学期
	 * @param  string $sno       学号
	 * @param  string $name      姓名
	 * @param  string $spno      专业号
	 * @param  string $grade     年级
	 * @param  string $season    招生季节
	 * @param  string $lcno      原课程号
	 * @param  string $lcname    原课程名称
	 * @param  string $lplatform 原课程平台
	 * @param  string $lproperty 原课程性质
	 * @param  string $lelective 原选修系列
	 * @param  string $method    考核方式
	 * @param  string $lcredit   原学分
	 * @param  string $lscore    原成绩
	 * @param  string $lgpa      原绩点
	 * @param  string $status    考试状态
	 * @param  string $cno       课程号
	 * @param  string $reason    申请理由
	 * @return boolean            申请成功返回TRUE，否则返回FALSE
	 */
	public function applyCreditTransfer($year, $term, $sno, $name, $spno, $grade, $season, $lcno, $lcname, $lplatform, $lproperty, $lelective, $method, $lcredit, $lscore, $lgpa, $status, $cno, $reason) {
		$data['nd']    = $year;
		$data['xq']    = $term;
		$data['xh']    = $sno;
		$data['xm']    = $name;
		$data['ykch']  = $lcno;
		$data['ykcmc'] = $lcname;
		$data['ypt']   = $lplatform;
		$data['ykcxz'] = $lproperty;
		$data['yxl']   = $lelective;
		$data['kh']    = $method;
		$data['yxf']   = $lcredit;
		$data['ycj']   = $lscore;
		$data['yjd']   = $lgpa;
		$data['kszt']  = $status;
		$data['sqly']  = $reason;
		$data['sqrq']  = date('Y-m-d H:i:s');
		$data['tjzt']  = '1';

		$sql    = 'SELECT a.kch, b.kcmc, a.pt, a.xz, a.zxf, a.xl FROM t_jx_jxjh a LEFT JOIN t_jx_kc b ON b.kch = a.kch AND b.zt = ? WHERE a.kch = ? AND a.zy = ? AND a.nj = ? AND a.zsjj = ?';
		$course = $this->db->getRow($sql, array(ENABLE, $cno, $spno, $grade, $season));

		if (has($course)) {
			$data['nkch']  = $cno;
			$data['nkcmc'] = $course['kcmc'];
			$data['npt']   = $course['pt'];
			$data['nkcxz'] = $course['xz'];
			$data['nxl']   = $course['xl'];
			$data['nxf']   = $course['zxf'];
		}

		$inserted = $this->db->insertRecord('t_cj_kczhsq', $data);

		$sql   = 'SELECT COUNT(*) FROM t_cj_kczhsq WHERE nd = ? AND xq = ? AND ykch = ? AND nkch = ?';
		$count = $this->db->getColumn($sql, array($year, $term, $lcno, $cno));

		return 0 < $count;
	}

	/**
	 * 撤销课程转换申请
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $sno  学号
	 * @param  string $lcno 原课程号
	 * @param  string $cno  8位课程号
	 * @return boolean       成功为TRUE，否则为FALSE
	 */
	public function revokeCreditTransfer($year, $term, $sno, $lcno, $cno) {
		$sql     = 'DELETE FROM t_cj_kczhsq WHERE nd = ? AND xq = ? AND xh = ? AND ykch = ? AND nkch = ?';
		$deleted = $this->db->delete($sql, array($year, $term, $sno, $lcno, $cno));

		return has($deleted);
	}

	/**
	 * 获取学生课程转换申请表
	 * @param  string $sno 学号
	 * @return boolean      有申请表返回TRUE，否则返回空数组
	 */
	public function getApplications($sno) {
		$sql  = 'SELECT * FROM t_cj_kczhsq WHERE xh = ? ORDER BY sqrq DESC';
		$data = $this->db->getAll($sql, array($sno));

		return has($data) ? $data : array();
	}

}
