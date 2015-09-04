<?php

/**
 * 考试模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class ExamModel extends StudentAdminModel {

	/**
	 * 获取考试信息
	 * @param  string $type 考试类型代码
	 * @return mixed       成功返回考试信息，否则返回FALSE
	 */
	public function getExamInfo($type) {
		$sql  = 'SELECT * FROM t_cj_kslxdm WHERE kslx = ?';
		$data = $this->db->getRow($sql, $type);

		return has($data) ? $data : false;
	}

	/**
	 * 检测是否已经报名
	 * @param  string  $sno  学号
	 * @param  string  $type 考试类型
	 * @param  string  $year 年度
	 * @return boolean       已经报名返回校区号，未报名为FALSE
	 */
	public function isRegistered($sno, $type, $year) {
		$sql  = 'SELECT * FROM t_ks_qtksbm WHERE nd = ? AND xh = ? AND kslx = ?';
		$data = $this->db->getRow($sql, array($year, $sno, $type));

		return has($data) ? $data : false;
	}

	/**
	 * 检测是否已经报名英语等级考试
	 * @param  string  $sno  学号
	 * @param  string  $year 年度
	 * @return boolean       已经报名返回考试名称，未报名则返回FALSE
	 */
	public function isRegisteredCET($sno, $year) {
		$sql  = 'SELECT b.ksmc FROM t_ks_qtksbm a LEFT JOIN t_cj_kslxdm b ON b.kslx = a.kslx WHERE a.nd = ? AND a.xh = ? AND b.ksdl = ? AND b.zt = ?';
		$data = $this->db->getColumn($sql, array($year, $sno, Config::get('exam.type.cet'), ENABLE));

		return has($data) ? $data : false;
	}

	/**
	 * 检测考试类型是否具有过往成绩
	 * @param  string  $sno  学号
	 * @param  string  $type 考试类型
	 * @return boolean       具有过往成绩返回TRUE，否则返回FALSE
	 */
	public function hasGrade($sno, $type) {
		$sql  = 'SELECT COUNT(*) FROM t_cj_qtkscj WHERE c_xh = ? AND c_kslx = ?';
		$data = $this->db->getColumn($sql, array($sno, $type));

		return has($data) && 0 < $data;
	}

	/**
	 * 检测是否有已经确认的报名信息
	 * @param  string  $sno 学号
	 * @return boolean      有则返回TRUE，否则返回FALSE
	 */
	public function hasConfirmed($sno) {
		$sql  = 'SELECT COUNT(*) FROM t_ks_qtksbm a INNER JOIN t_cj_kslxdm b ON b.kslx = a.kslx AND b.nd = a.nd WHERE a.xh = ? AND a.clbz = ? AND b.zt = ?';
		$data = $this->db->getColumn($sql, array($sno, Config::get('exam.passed'), ENABLE));

		return has($data) && 0 < $data;
	}

	/**
	 * 检测是否限制报名
	 * @param  string  $type       考试类型
	 * @param  string  $speciality 专业
	 * @return boolean             允许报名为ENABLE，禁止报名为DISABLE
	 */
	public function isAllowedRegister($type, $speciality) {
		$sql    = 'SELECT zt FROM t_ks_bmzyxz WHERE kslx = ? AND zy = ?';
		$status = $this->db->getColumn($sql, array($type, $speciality));

		return has($status) ? $status : DISABLE;
	}

	/**
	 * 检测学生相应的考试类型是否及格
	 * @param  string  $sno  学号
	 * @param  string  $types 考试类型
	 * @return boolean       及格为TRUE，不及格为FALSE
	 */
	public function isPassed($sno, $types) {
		// SQL：查找是否存在指定考试类型及格的成绩
		$sql   = 'SELECT EXISTS(SELECT 1 FROM t_cj_qtkscj a WHERE a.c_xh = ? AND a.c_kslx IN(?) AND a.c_cj > (SELECT jgx FROM t_cj_kslxdm b WHERE b.kslx = a.c_kslx))';
		$score = $this->db->getColumn($sql, array($sno, array_to_pg($types)));
		/*
		$sql    = 'SELECT c_cj FROM t_cj_qtkscj WHERE c_xh = ? AND c_kslx = ?';
		$scores = $this->db->getAll($sql, array($sno, $type));

		$sql      = 'SELECT jgx FROM t_cj_kslxdm WHERE kslx = ?';
		$passline = $this->db->getColumn($sql, array($type));
		$passline = (FALSE===$passline)?Config::get('score.passline'):$passline;

		$passed = false;
		foreach ($scores as $score) {
		if ($score['c_cj'] >= $passline) {
		$passed = true;
		break;
		}
		}
		 */
		return $passed ? true : false;
	}

	/**
	 * 检测是否允许CET4和CET6同时报名
	 * @return boolean 允许同时报名为TRUE，否则为FALSE
	 */
	public function isAllowedCET4AndCET6() {
		return ENABLE != Setting::get('KS_CET');
	}

	/**
	 * 检测是否允许新生报考CET4
	 * @return boolean 允许报名为TRUE，否则为FALSE
	 */
	public function isAllowedFreshRegisterCET4() {
		return ENABLE != Setting::get('KS_CET4_XS');
	}

	/**
	 * 考试报名
	 * @param  string $sno    学号
	 * @param  string $type   考试类型
	 * @param  string $campus 校区号
	 * @param  string $date   考试时间
	 * @param  string $year   考试年度
	 * @return boolean         报名成功为TRUE，否则为FALSE
	 */
	public function register($sno, $type, $campus, $date, $year) {
		$data['xh']   = $sno;
		$data['xq']   = $campus;
		$data['kslx'] = $type;
		$data['bklb'] = '00';
		$data['kssj'] = $date;
		$data['clbz'] = Config::get('exam.status.register');
		$data['bmsj'] = date('Y-m-d H:i:s');
		$data['nd']   = $year;

		$inserted = $this->db->insertRecord('t_ks_qtksbm', $data);

		$sql   = 'SELECT COUNT(*) FROM t_ks_qtksbm WHERE xh = ? AND kslx = ? AND kssj = ?';
		$count = $this->db->getColumn($sql, array($sno, $type, $date));
		if (0 < $count) {
			Logger::write(array('xh' => $sno, 'czlx' => Config::get('log.register')));
			return true;
		}

		return false;
	}

	/**
	 * 取消考试报名
	 * @param  string $sno  学号
	 * @param  string $type 考试类型
	 * @param  string $date 考试时间
	 * @return boolean       取消报名成功为TRUE，否则为FALSE
	 */
	public function cancel($sno, $type, $date) {
		$sql     = 'DELETE FROM t_ks_qtksbm WHERE xh = ? AND kslx = ? AND kssj = ? AND clbz = ?';
		$deleted = $this->db->delete($sql, array($sno, $type, $date, Config::get('exam.status.register')));

		if (has($deleted)) {
			Logger::write(array('xh' => $sno, 'czlx' => Config::get('log.cancel')));
			return true;
		}

		return false;
	}

	/**
	 * 列出报名信息
	 * @param  string $sno 学号
	 * @return mixed      成功返回报名信息列表，否则返回空数组
	 */
	public function listRegister($sno) {
		$sql  = 'SELECT b.ksmc, a.xq, a.kssj, a.bmsj FROM t_ks_qtksbm a LEFT JOIN t_cj_kslxdm b ON b.kslx = a.kslx WHERE xh = ? ORDER BY a.bmsj DESC';
		$data = $this->db->getAll($sql, $sno);

		return has($data) ? $data : array();
	}

	/**
	 * 获取考试类型
	 * @param  string $sno 学号
	 * @param  string $speciality 专业号
	 * @return array             成功返回考试类型列表，否则返回空数组
	 */
	public function getTypes($sno, $speciality) {
		$sql  = 'SELECT a.kslx, a.ksmc, b.ksdl, b.mc AS ksdlmc FROM t_cj_kslxdm a LEFT JOIN t_cj_ksdl b ON a.ksdl = b.ksdl WHERE a.zt = ? ORDER BY b.ksdl, a.kslx';
		$data = $this->db->getAll($sql, ENABLE);

		$types = array();
		if (has($data) && is_array($data)) {
			foreach ($data as $type) {
				if (Config::get('exam.type.cet4') == $type['kslx']) {
					if (!$this->isAllowedFreshRegisterCET4()) {
						$student = new StudentModel();
						if ($student->isFresh($sno) && !$student->isUndergraduate($sno)) {
							continue;
						}
					}
				}

				if (Config::get('exam.type.cet6') == $type['kslx']) {
					if (!$this->hasGrade($sno, Config::get('exam.type.cet6')) && !$this->isPassed($sno, array(Config::get('exam.type.cet4'), Config::get('exam.type.cjt4'), Config::get('exam.type.cft4'), Config::get('exam.type.crt4'), Config::get('exam.type.cgt4')))) {
						continue;
					}
				}

				$types[$type['ksdl']][] = $type;
			}
		}

		return $types;
	}

}
