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
	 * @param  string  $date 考试时间
	 * @return boolean       已经报名为TRUE，未报名为FALSE
	 */
	public function isRegistered($sno, $type, $date) {
		$sql  = 'SELECT COUNT(*) FROM t_ks_qtksbm WHERE xh = ? AND kslx = ? AND kssj = ?';
		$data = $this->db->getColumn($sql, array($sno, $type, $date));

		return has($data) ? true : false;
	}

	/**
	 * 检测是否限制报名
	 * @param  string  $type       考试类型
	 * @param  string  $speciality 专业
	 * @param  string  $college    学院
	 * @return boolean             允许报名为ENABLE，禁止报名为DISABLE
	 */
	public function isAllowedRegister($type, $speciality, $college) {
		$sql    = 'SELECT zt FROM t_ks_bmzyxz WHERE kslx = ? AND zy = ? AND xy = ?';
		$status = $this->db->getColumn($sql, array($type, $specility, $college));

		return has($status) ? $status : (DISABLE == $status ? DISABLE : ENABLE);
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

		$sql      = 'SELECT jgx FROM t_cj_kslxdm WHERE c_kslx = ?';
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
	 * @return boolean         报名成功为TRUE，否则为FALSE
	 */
	public function register($sno, $type, $campus, $date) {
		$data['xh']   = $sno;
		$data['xq']   = $campus;
		$data['kslx'] = $type;
		$data['bklb'] = '00';
		$data['kssj'] = $date;
		$data['clbz'] = Config::get('exam.status.register');
		$data['bmsj'] = date('Y-m-d H:i:s');

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
}