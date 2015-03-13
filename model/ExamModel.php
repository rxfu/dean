<?php

/**
 * 考试模型类
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
		$sql  = 'SELECT xq FROM t_ks_qtksbm WHERE xh = ? AND kslx = ? AND nd = ?';
		$data = $this->db->getColumn($sql, array($sno, $type, $year));

		return has($data) ? $data : false;
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
	 * @param  string  $type 考试类型
	 * @return boolean       及格为TRUE，不及格为FALSE
	 */
	public function isPassed($sno, $type) {
		$sql    = 'SELECT c_cj FROM t_cj_qtkscj WHERE c_xh = ? AND c_kslx = ?';
		$scores = $this->db->getAll($sql, array($sno, $type));

		$sql      = 'SELECT jgx FROM t_cj_kslxdm WHERE kslx = ?';
		$passline = $this->db->getColumn($sql, array($type));

		$passed = false;
		foreach ($scores as $score) {
			if ($score >= $passline) {
				$passed = true;
				break;
			}
		}

		return $passed;
	}

	/**
	 * 检测是否允许CET4和CET6同时报名
	 * @return boolean 允许同时报名为TRUE，否则为FALSE
	 */
	public function isAllowedCET4AndCET6() {
		return 1 != Setting::get('KS_CET');
	}

	/**
	 * 检测是否允许新生报考CET4
	 * @return boolean 允许报名为TRUE，否则为FALSE
	 */
	public function isAllowedFreshRegisterCET4() {
		return 1 != Setting::get('KS_CET4_XS');
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
		if (has($inserted)) {
			Logger::write(array('xh' => $sno, 'czlx' => Config::get('log.register')));
			return true;
		}

		return false;
	}

	/**
	 * 列出报名信息
	 * @param  string $sno 学号
	 * @return mixed      成功返回报名信息列表，否则返回FALSE
	 */
	public function listRegister($sno) {
		$sql  = 'SELECT b.ksmc, a.xq, a.kssj, a.bmsj FROM t_ks_qtksbm a LEFT JOIN t_cj_kslxdm b ON b.kslx = a.kslx WHERE xh = ? ORDER BY a.bmsj DESC';
		$data = $this->db->getAll($sql, $sno);

		return has($data) ? $data : false;
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
				if (Config::get('exam.type.cet3') == $type['kslx']) {
					if (DISABLE == $this->isAllowedRegister($type, $speciality)) {
						continue;
					}
				}

				if (Config::get('exam.type.cet4') == $type['kslx']) {
					if (ENABLE == $this->isAllowedRegister($type, $speciality)) {
						if (!$this->isPassed($sno, Config::get('exam.type.cet3'))) {
							continue;
						}
					}

					if (!$this->isAllowedFreshRegisterCET4()) {
						$student = new StudentModel();
						if ($student->isFresh($sno && !$student->isUndergraduate($sno))) {
							continue;
						}
					}
				}

				if (Config::get('exam.type.cet6') == $type['kslx']) {
					if (ENABLE == $this->isAllowedRegister($type, $speciality)) {
						if (!$this->isPassed($sno, Config::get('exam.type.cet3'))) {
							continue;
						}
					}

					if (!$this->isPassed($sno, Config::get('exam.type.cet4'))) {
						continue;
					}
				}

				$types[$type['ksdl']][] = $type;
			}
		}

		return $types;
	}

}
