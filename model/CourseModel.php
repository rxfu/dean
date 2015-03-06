<?php

/**
 * 课程模型类
 */
class CourseModel extends StudentAdminModel {

	/**
	 * 判断是否通识素质课程
	 * @param  string  $type 课程类型
	 * @return boolean       是通识素质课为TRUE，否则为FALSE
	 */
	public function isGeneralCourse($type) {
		$codes = array_column(array(
			Config::get('course.type.humanity'),
			Config::get('course.type.natural'),
			Config::get('course.type.art'),
			Config::get('course.type.special'),
		), 'code');

		return in_array($type, $codes);
	}

	/**
	 * 判断是否专业课程
	 * @param  string  $type 课程类型
	 * @return boolean       是专业课程为TRUE，否则为FALSE
	 */
	public function isSpecializedCourse($type) {
		$codes = array_column(array(
			Config::get('course.type.basic'),
			Config::get('course.type.required'),
			Config::get('course.type.elective'),
		), 'code');

		return in_array($type, $codes);
	}

	/**
	 * 判断是否允许选课
	 * @return boolean 允许为TRUE，禁止为FALSE
	 */
	public function isOpen() {
		return ENABLE == Setting::get('XK_KG') ? true : false;
	}

	/**
	 * 判断是否允许选择通识素质课
	 * @return boolean 允许为TRUE，禁止为FALSE
	 */
	public function isGeneralOpen() {
		return ENABLE == Setting::get('XK_TS') ? true : false;
	}

	/**
	 * 判断是否允许选择其他课程
	 * @return boolean 允许为TRUE，禁止为FALSE
	 */
	public function isOthersOpen() {
		return ENABLE == Setting::get('XK_QT') ? true : false;
	}

	/**
	 * 获取选课学分限制
	 * @return string 学分限制，0为无限制
	 */
	public function getLimitCredit() {
		return Setting::get('XK_XF');
	}

	/**
	 * 获取选课门数限制
	 * @return string 门数限制，0为无限制
	 */
	public function getLimitCourse() {
		return Setting::get('XK_MS');
	}

	/**
	 * 判断是否允许选课
	 * @param  string $time   当前时间
	 * @param  string $grade  年级
	 * @param  string $system 学制
	 * @return boolean         允许选课为TRUE，否则为FALSE
	 */
	public function isAllowedCourse($time, $grade, $system) {
		$allow = true;
		if (ENABLE == Setting::get('XK_SJXZ')) {
			$sql  = 'SELECT kssj, jssj FROM t_xk_sjxz WHERE nj = ? AND xz = ?';
			$data = $this->db->getRow($sql, array($this->session->get('grade'), $this->session->get('system')));

			if (hasData($data)) {
				$allow = ($time >= $data['kssj']) && ($time <= $data['jssj']);
			}
		}

		return $allow;
	}

	/**
	 * 判断是否允许选通识素质课
	 * @param  string  $time   选课时间
	 * @param  string  $grade  年级
	 * @param  string  $system 学制
	 * @param  string  &$count 课程门数
	 * @param  string  &$ratio 人数比例
	 * @return boolean         允许选课为TRUE，否则为FALSE
	 */
	public function isAllowedGeneralCourse($time, $grade, $system, &$count, &$ratio) {
		$allow = true;
		if (ENABLE == Setting::get('XK_TSXZ')) {
			$sql  = 'SELECT * FROM t_xk_tsxz WHERE nj = ? AND xz = ?';
			$data = $this->db->getRow($sql, array($this->session->get('grade'), $this->session->get('system')));

			if (hasData($data)) {
				$allow = ($time >= $data['kssj']) && ($time <= $data['jssj']);
				$count = $data['ms'];
				$ratio = $data['bl'] / 100;
			}
		}

		return $allow;
	}

	/**
	 * 判断是否有未修读的前修课程
	 * @param  string  $sno  学号
	 * @param  array  $cnos 课程号数组
	 * @return boolean       有未修读的前修课返回array，没有返回FALSE
	 */
	public function hasPrevious($sno, $cnos) {
		$sql  = 'SELECT b.kch2 FROM t_cj_zxscj a JOIN t_jx_kc_qxgx b ON a.xf <= 0 AND a.xh = ? AND a.kch = b.kch AND b.gx = ? AND b.kch2 = ANY(' . array_to_pg($cnos) . ')';
		$data = $this->db->getAll($sql, array($sno, '>'));

		return hasData($data) ? array_column($data, 'kch2') : false;
	}

}