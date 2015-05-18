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
	 * @param  string $platform 课程平台
	 * @param  string $property 课程性质
	 * @return mixed             成功返回毕业要求，否则返回FALSE
	 */
	public function getGraduation($grade, $speciality, $season, $plan, $platform = null, $property = null) {
		$sql = 'SELECT * FROM t_jx_byyq WHERE nj = ? AND zy = ? AND zsjj = ? AND byfa = ?';
		$sql .= is_null($platform) ? '' : ' AND pt = ?';
		$sql .= is_null($property) ? '' : ' AND xz = ?';
		$data = $this->db->getAll($sql, array($grade, $speciality, $season, $plan, $platform, $property));

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
	 * 获取正在修读学分
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $sno  学号
	 * @param  string $platform 课程平台
	 * @param  string $property 课程性质
	 * @return mixed       成功返回正在修读学分，否则返回空数组
	 */
	public function getStudyingCredits($year, $term, $sno, $platform = null, $property = null) {
		if ('1' == $term) {
			$year -= 1;
			$term += 1;
		} else {
			$term -= 1;
		}

		$sql = 'SELECT pt, xz, SUM(xf) as xf FROM t_xk_xkxx WHERE nd = ? AND xq = ? AND xh = ?';
		$sql .= is_null($platform) ? '' : ' AND pt = ?';
		$sql .= is_null($property) ? '' : ' AND xz = ?';
		$sql .= ' GROUP BY pt, xz';
		$data = $this->db->getAll($sql, array($year, $term, $sno, $platform, $property));

		return has($data) ? $data : array();
	}

	/**
	 * 获取已修读学分
	 * @param  string $sno 学号
	 * @param  string $platform 课程平台
	 * @param  string $property 课程性质
	 * @return mixed      成功返回已修读学分，否则返回FALSE
	 */
	public function getStudiedCredits($sno, $platform = null, $property = null) {
		$sql = 'SELECT pt, kcxz, SUM(xf) AS xf FROM t_cj_zxscj WHERE xh = ?';
		$sql .= is_null($platform) ? '' : ' AND pt = ?';
		$sql .= is_null($property) ? '' : ' AND kcxz = ?';
		$sql .= ' GROUP BY pt, kcxz';
		$data = $this->db->getAll($sql, array($sno, $platform, $property));

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

	/**
	 * 获取学生已修成绩
	 * @param  string $sno      学号
	 * @param  string $platform 课程平台
	 * @param  string $property 课程性质
	 * @return mixed           成功返回学生成绩，否则返回空数组
	 */
	public function getReport($sno, $platform, $property) {
		$sql = 'SELECT a.nd,
				a.xq,
				a.kch,
				b.kcmc,
				a.pt,
				a.kcxz,
				a.kh,
				a.cj,
				a.bkcj,
				a.cxcj,
				c.mc AS kszt,
				a.xf,
				a.jd
				 FROM t_cj_zxscj a
				 INNER JOIN t_jx_kc b ON b.kch = a.kch
				 LEFT JOIN t_cj_kszt c ON c.dm = a.kszt
				 WHERE xh = ? AND pt = ? AND kcxz = ?
				 ORDER BY nd DESC, xq DESC';
		$data = $this->db->getAll($sql, array($sno, $platform, $property));

		return has($data) ? $data : array();
	}

	/**
	 * 获取当前学生正在修读课程信息
	 * @param  string $year     年度
	 * @param  string $term     学期
	 * @param  string $sno      学号
	 * @param  string $platform 课程平台
	 * @param  string $property 课程性质
	 * @return mixed           成功返回正在修读课程信息，否则返回空数组
	 */
	public function getStudyingReport($year, $term, $sno, $platform, $property) {
		if ('1' == $term) {
			$year -= 1;
			$term += 1;
		} else {
			$term -= 1;
		}

		$sql = 'SELECT DISTINCT a.kcxh,
				b.kcmc,
				a.pt,
				a.xz,
				a.xf
				 FROM t_xk_xkxx a
				 INNER JOIN t_jx_kc b ON b.kch = a.kch
				 WHERE a.nd = ? AND a.xq = ? AND a.xh = ? AND a.pt = ? AND a.xz = ?';
		$data = $this->db->getAll($sql, array($year, $term, $sno, $platform, $property));

		return has($data) ? $data : array();
	}

	/**
	 * 获取未修读课程列表
	 * @param  string $sno    学号
	 * @param  string $grade  年级
	 * @param  string $spno   专业号
	 * @param  string $season 招生季节
	 * @return mixed         成功返回未修读课程列表，否则返回空数组
	 */
	public function getUnstudiedCourses($sno, $grade, $spno, $season) {
		$sql = 'SELECT DISTINCT a.kch,
				c.kcmc,
				a.pt,
				a.xz,
				a.kxq,
				a.zxf
				 FROM t_jx_jxjh a
				 LEFT JOIN t_xk_xkxx b ON b.kch = a.kch AND b.xh = ?
				 INNER JOIN t_jx_kc c ON c.kch = a.kch
				 WHERE a.zy = ? AND a.nj = ? AND a.zsjj = ? AND a.xz = ? AND b.kch IS NULL';
		$data = $this->db->getAll($sql, array($sno, $spno, $grade, $season, 'B'));

		return has($data) ? $data : array();
	}

	/**
	 * 获取专业选修课程
	 * @param  string $grade  年级
	 * @param  string $spno   专业号
	 * @param  string $season 招生季节
	 * @return mixed         成功返回专业选修课程，否则返回空数组
	 */
	public function getElectiveCourses($grade, $spno, $season) {
		$sql = 'SELECT DISTINCT a.kch,
				b.kcmc,
				a.pt,
				a.xz,
				a.kxq,
				a.zxf
				 FROM t_jx_jxjh a
				 INNER JOIN t_jx_kc b ON b.kch = a.kch
				 WHERE a.zy = ? AND a.nj = ? AND a.zsjj = ? AND a.xz = ?';
		$data = $this->db->getAll($sql, array($spno, $grade, $season, 'X'));

		return has($data) ? $data : array();
	}

}
