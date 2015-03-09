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
			Config::get('course.type.hs'),
			Config::get('course.type.ns'),
			Config::get('course.type.as'),
			Config::get('course.type.os'),
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
			Config::get('course.type.bsc'),
			Config::get('course.type.req'),
			Config::get('course.type.lct'),
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

			if (has($data)) {
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

			if (has($data)) {
				$allow = ($time >= $data['kssj']) && ($time <= $data['jssj']);
				$count = $data['ms'];
				$ratio = $data['bl'] / 100;
			}
		}

		return $allow;
	}

	/**
	 * 判断是否有已经选择的课程
	 * @param  string  $sno  学号
	 * @param  string  $cnos 12位课程序号数组
	 * @return mixed       有返回已选课程数组，没有返回FALSE
	 */
	public function hasSelected($sno, $year, $term, $cnos) {
		$sql  = 'SELECT kcxh FROM t_xk_xkxx WHERE nd = ? AND xq = ? AND xh = ? AND kcxh = ANY(?)';
		$data = $this->db->getAll($sql, array($year, $term, $sno, array_to_pg($cnos)));

		return has($data) ? array_column($data, 'kcxh') : false;
	}

	/**
	 * 判断课程是否有考试成绩
	 * @param  string  $sno  学号
	 * @param  array  $cnos 8位课程号数组
	 * @return mixed       返回具有成绩的课程号，没有返回FALSE
	 */
	public function hasScore($sno, $cnos) {
		$sql  = 'SELECT kch FROM t_cj_zxscj WHERE xh = ? AND kch = ANY(?)';
		$data = $this->db->getAll($sql, array($sno, array_to_pg($cnos)));

		return has($data) ? array_column($data, 'kch') : false;
	}

	/**
	 * 判断是否有未修读的前修课程
	 * @param  string  $sno  学号
	 * @param  array  $cnos 8位课程号数组
	 * @return mixed       有返回未修读的前修课数组，没有返回FALSE
	 */
	public function hasPrevious($sno, $cnos) {
		$sql  = 'SELECT b.kch2 FROM t_cj_zxscj a JOIN t_jx_kc_qxgx b ON a.xf <= 0 AND a.xh = ? AND a.kch = b.kch AND b.gx = ? AND b.kch2 = ANY(?)';
		$data = $this->db->getAll($sql, array($sno, '>', array_to_pg($cnos)));

		return has($data) ? array_column($data, 'kch2') : false;
	}

	/**
	 * 列出可选课程
	 * @param  string $year       年度
	 * @param  string $term       学期
	 * @param  string $season     招生季节
	 * @param  string $sno     	  学号
	 * @param  string $platform   平台
	 * @param  string $property   性质
	 * @param  string $grade      年级
	 * @param  string $speciality 专业
	 * @return array             可选课程数组，没有返回空数组
	 */
	public function listCourse($year, $term, $season, $sno, $platform = null, $property = null, $grade = null, $speciality = null) {
		$sql    = 'SELECT * FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND zsjj = ?';
		$params = array($year, $term, $season);
		if (!isEmpty($grade)) {
			$sql .= ' AND nj = ?';
			$params[] = $grade;
		}
		if (!isEmpty($speciality)) {
			$sql .= ' AND zy = ?';
			$params[] = $speciality;
		}
		if (!isEmpty($platform)) {
			if (is_array($platform)) {
				$sql .= ' AND pt = ANY(?)';
				array_walk($platform, function (&$pf) {
					$pf = strtoupper($pf);
				});
				$params[] = array_to_pg($platform);
			} else {
				$sql .= ' AND pt = ?';
				$params[] = strtoupper($platform);
			}
		}
		if (!isEmpty($property)) {
			$sql .= ' AND xz = ?';
			$params[] = strtoupper($property);
		}

		$courses = $this->db->getAll($sql, $params);
		if (has($courses)) {
			// 检测已修读课程，已修读则从选课列表中删除
			$cnos   = array_column($courses, 'kch');
			$delete = $this->hasScore($sno, $cnos);
			if (has($delete)) {
				foreach ($courses as &$course) {
					if (in_array($course['kch'], $delete)) {
						unset($course);
					}
				}
				$courses = array_values($courses);
			}
			array_walk($courses, function (&$course) {
				$course['zt'] = Config::get('course.select.selectable');
			});

			$forbidden    = $this->hasPrevious($sno, array_column($courses, 'kch'));
			$selected     = $this->hasSelected($sno, $year, $term, array_column($courses, 'kcxh'));
			$modifyStatus = function (&$course) use ($forbidden, $selected) {
				if (has($forbidden) && in_array($course['kch'], $forbidden)) {
					$course['zt'] = Config::get('course.select.forbidden');
				}
				if ($course['jhrs'] <= $course['rs']) {
					$course['zt'] = Config::get('course.select.forbidden');
				}
				if (has($selected) && in_array($course['kcxh'], $selected)) {
					$course['zt'] = Config::get('course.select.selected');
				}
			};
			array_walk($courses, $modifyStatus);
		}

		return $courses;
	}

	/**
	 * 判断通识素质课选课门数是否超过门数限制
	 * @param  string  $year 年度
	 * @param  string  $term 学期
	 * @param  string  $sno  学号
	 * @param  string  $limit  限制门数
	 * @return boolean       超过限制为TRUE，否则为FALSE
	 */
	public function isExceedCourseLimit($year, $term, $sno, $limit) {
		if (0 > $limit) {
			return false;
		}

		$sql  = 'SELECT ms FROM v_xk_tssztj WHERE nd = ? AND xq = ? AND xh = ?';
		$data = $this->db->getColumn($sql, array($year, $term, $sno));

		return has($data) ? ($limit <= $data) : false;
	}

}
