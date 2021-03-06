<?php

/**
 * 课程模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
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
	 * 判断是否其他课程
	 * @param  string  $type 课程类型
	 * @return boolean       是其他课程为TRUE，否则为FALSE
	 */
	public function isOtherCourse($type) {
		return Config::get('course.type.others.code') === $type;
	}

	/**
	 * 判断是否重修课程
	 * @param  string  $type 课程类型
	 * @return boolean       是重修课程为TRUE，否则为FALSE
	 */
	public function isRetakeCourse($type) {
		return Config::get('course.type.retake.code') === $type;
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
	 * 获取年度、学期对应的年级
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return mixed       成功返回年级列表，否则返回FALSE
	 */
	public function getGrades($year, $term) {
		$sql  = 'SELECT DISTINCT nj FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND nj <> \'\' ORDER BY nj';
		$data = $this->db->getAll($sql, array($year, $term));

		return has($data) ? $data : false;
	}

	/**
	 * 获取学院信息
	 * @return mixed  成功返回学院信息，否则返回FALSE
	 */
	public function getColleges() {
		$sql  = 'SELECT dw, mc FROM t_xt_department WHERE lx = ? AND zt = ? ORDER BY dw';
		$data = $this->db->getAll($sql, array(Config::get('department.college'), ENABLE));

		return has($data) ? $data : false;
	}

	/**
	 * 获取专业信息
	 * @return mixed 成功返回专业信息，否则返回FALSE
	 */
	public function getSpecialities() {
		$sql  = 'SELECT zy, mc, xy FROM t_jx_zy WHERE zt = ? ORDER BY zy';
		$data = $this->db->getAll($sql, array(ENABLE));

		return has($data) ? $data : false;
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
			$data = $this->db->getRow($sql, array($grade, $system));

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
			$data = $this->db->getRow($sql, array($grade, $system));

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
	 * @param  string $cno      课程号
	 * @param  string $cname 课程名称
	 * @return array             可选课程数组，没有返回空数组
	 */
	public function listCourse($year, $term, $season, $sno, $platform = null, $property = null, $grade = null, $speciality = null, $cno = null, $cname = null) {
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
			if ('others' == $property) {
				$sql .= " AND CASE WHEN pt = 'T' THEN xz <> 'W' AND xz <> 'I' AND xz <> 'Y' AND xz <> 'Q' ELSE true END";
			} else {
				$sql .= ' AND xz = ?';
				$params[] = strtoupper($property);
			}
		}
		if (!isEmpty($cno)) {
			$sql .= ' AND kcxh LIKE \'%' . $cno . '%\'';
		}
		if (!isEmpty($cname)) {
			$sql .= ' AND kcmc LIKE \'%' . $cname . '%\'';
		}

		$courses = $this->db->getAll($sql, $params);
		if (has($courses)) {
			// 检测已修读课程，已修读则从选课列表中删除
			/*
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
			 */
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

	/**
	 * 选择课程
	 * @param  string $year       年度
	 * @param  string $term       学期
	 * @param  string $season     招生季节
	 * @param  string $sno        学号
	 * @param  string $name       姓名
	 * @param  string $grade      年级
	 * @param  string $speciality 专业
	 * @param  string $cno        12位课程序号
	 * @return boolean             成功返回TRUE，否则返回FALSE
	 */
	public function select($year, $term, $season, $sno, $name, $grade, $speciality, $cno) {
		$sql   = 'SELECT COUNT(*) FROM t_xk_tj WHERE kcxh = ?';
		$count = $this->db->getColumn($sql, $cno);
		if (0 >= $count) {
			$sql      = 'SELECT kcxh, COUNT(xh) AS rs FROM t_xk_xkxx WHERE nd = ? AND xq = ? AND kcxh = ? GROUP BY kcxh';
			$selcount = $this->db->getRow($sql, array($year, $term, $cno));

			$data['kcxh'] = $cno;
			$data['rs']   = has($selcount) ? $selcount['rs'] : 0;
			$inserted     = $this->db->insertRecord('t_xk_tj', $data);
		}

		$param    = "'" . implode("', '", array($year, $term, $sno, $cno, $name, $grade, $speciality, $season)) . "'";
		$selected = $this->db->query('SELECT p_xzkc_save(' . $param . ')');
		if ($selected) {
			$sql   = 'SELECT COUNT(*) FROM t_xk_xkxx WHERE nd = ? AND xq = ? AND xh = ? AND kcxh = ?';
			$count = $this->db->getColumn($sql, array($year, $term, $sno, $cno));

			if (has($count) && 0 < $count) {
				Logger::write(array('xh' => $sno, 'kcxh' => $cno, 'czlx' => Config::get('log.select')));
				return true;
			}
		}

		return false;
	}

	/**
	 * 退选课程
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $sno  学号
	 * @param  string $cno  12位课程号
	 * @return boolean       成功返回TRUE，否则返回FALSE
	 */
	public function drop($year, $term, $sno, $cno) {
		$param   = "'" . implode("', '", array($year, $term, $sno, $cno)) . "'";
		$deleted = $this->db->query('SELECT p_scxk_del(' . $param . ')');
		if ($deleted) {
			$sql   = 'SELECT COUNT(*) FROM t_xk_xkxx WHERE nd = ? AND xq = ? AND xh = ? AND kcxh = ?';
			$count = $this->db->getColumn($sql, array($year, $term, $sno, $cno));

			if (0 == $count) {
				Logger::write(array('xh' => $sno, 'kcxh' => $cno, 'czlx' => Config::get('log.drop')));
				return true;
			}
		}

		return false;
	}

	/**
	 * 申请课程
	 * @param  string $year  年度
	 * @param  string $term  学期
	 * @param  string $sno   学号
	 * @param  string $name  姓名
	 * @param  string $cno   12位课程序号
	 * @param  string $type  选课类型
	 * @param  string $lyear 原年度
	 * @param  string $lterm 原学期
	 * @param  string $lcno  12位原课程序号
	 * @param  string $lcredit 原学分
	 * @return boolean        成功返回TRUE，否则返回FALSE
	 */
	public function apply($year, $term, $sno, $name, $cno, $type, $lyear = null, $lterm = null, $lcno = null, $lcredit = null) {
		$data['nd']   = $year;
		$data['xq']   = $term;
		$data['xh']   = $sno;
		$data['xm']   = $name;
		$data['kcxh'] = $cno;
		$data['xksj'] = date('Y-m-d H:i:s');
		$data['xklx'] = $type;

		$sql    = 'SELECT kch, pt, xz, xf, kkxy FROM v_xk_kxkcxx WHERE kcxh = ? AND nd = ? AND xq = ?';
		$course = $this->db->getRow($sql, array($cno, $year, $term));
		if (has($course)) {
			$data['kch']  = $course['kch'];
			$data['pt']   = $course['pt'];
			$data['xz']   = $course['xz'];
			$data['xf']   = $course['xf'];
			$data['kkxy'] = $course['kkxy'];
		}

		if (Config::get('course.apply.retake') == $type) {
			$data['ynd']   = $lyear;
			$data['yxq']   = $lterm;
			$data['ykcxh'] = $lcno;
			$data['yxf']   = $lcredit;
		}

		$inserted = $this->db->insertRecord('t_xk_xksq', $data);

		$sql   = 'SELECT COUNT(*) FROM t_xk_xksq WHERE xh = ? AND nd = ? AND xq = ? AND kcxh = ?';
		$count = $this->db->getColumn($sql, array($sno, $year, $term, $cno));
		if (0 < $count) {
			Logger::write(array('xh' => $sno, 'kcxh' => $cno, 'czlx' => Config::get('log.apply_course')));
			return true;
		}

		return false;
	}

	/**
	 * 撤销选课申请
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $sno  学号
	 * @param  string $cno  12位课程序号
	 * @return boolean       成功为TRUE，否则为FALSE
	 */
	public function revoke($year, $term, $sno, $cno) {
		$sql     = 'DELETE FROM t_xk_xksq WHERE nd = ? AND xq = ? AND xh = ? AND kcxh = ?';
		$deleted = $this->db->delete($sql, array($year, $term, $sno, $cno));

		if (has($deleted)) {
			Logger::write(array('xh' => $sno, 'kcxh' => $cno, 'czlx' => Config::get('log.revoke_course')));
			return true;
		}

		return false;
	}

	/**
	 * 获取学生课程表
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $sno  学号
	 * @return mixed       有课程表则返回课程表，否则返回FALSE
	 */
	public function getTimetable($year, $term, $sno) {
		$sql  = 'SELECT * FROM v_xk_xskcb WHERE nd = ? AND xq = ? AND xh = ?';
		$data = $this->db->getAll($sql, array($year, $term, $sno));

		return has($data) ? $data : false;
	}

	/**
	 * 获取学生选课申请表
	 * @param  string $sno 学号
	 * @return boolean      有申请表返回TRUE，否则返回空数组
	 */
	public function getApplications($sno) {
		$sql  = 'SELECT * FROM t_xk_xksq WHERE xh = ? ORDER BY xksj DESC';
		$data = $this->db->getAll($sql, array($sno));

		return has($data) ? $data : array();
	}

	/**
	 * 获取学生可重修课程列表
	 * @param  string $sno 学号
	 * @param string $year 年度
	 * @param string $term 学期
	 * @return array      返回可重修课程列表
	 */
	public function getRetakableCourse($sno, $year, $term) {
		$sql            = 'SELECT DISTINCT a.nd, a.xq, a.kcxh, b.kcmc, a.xf FROM t_xk_xkxx a LEFT JOIN t_jx_kc b ON b.kch = a.kch WHERE a.xh = ? AND (a.nd <> ? OR a.xq <> ?) AND a.cx = ? ORDER BY a.kcxh';
		$course['cnos'] = $this->db->getAll($sql, array($sno, $year, $term, DISABLE));

		return $course;
	}

	/**
	 * 检测选课时间是否冲突
	 * @param  string  $year 年度
	 * @param  string  $term 学期
	 * @param  string  $sno  学号
	 * @param  string  $cno  12位课程序号
	 * @return mixed       冲突返回冲突的课程序号，否则返回FALSE
	 */
	public function isClash($year, $term, $sno, $cno) {
		$sql      = 'SELECT kcxh, ksz, jsz, zc, ksj, jsj FROM t_pk_kb WHERE nd = ? AND xq = ? AND kcxh = ?';
		$currents = $this->db->getAll($sql, array($year, $term, $cno));
		$compares = $this->getTimetable($year, $term, $sno);

		if (has($currents) && has($compares)) {
			foreach ($currents as $current) {
				foreach ($compares as $compare) {
					if ($compare['zc'] == $current['zc']) {
						if (between($current['ksj'], $compare['ksj'], $compare['jsj'])) {
							if (between($current['ksz'], $compare['ksz'], $compare['jsz'])) {
								$collision[] = $compare['kcxh'];
							}
						}
					}
				}
			}
		}

		return isset($collision) && is_array($collision) ? $collision : false;
	}

	/**
	 * 检测所选课程是否人数已满
	 * @param  string  $year 年度
	 * @param  string  $term 学期
	 * @param  string  $cno  课程序号
	 * @param string $ratio 人数比例
	 * @param string $speciality 专业号
	 * @return boolean       人数已满为TRUE，否则为FALSE
	 */
	public function isFull($year, $term, $cno, $ratio = 1, $speciality = null) {
		$sql = 'SELECT jhrs, rs FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		if (is_null(null)) {
			$data = $this->db->getRow($sql, array($year, $term, $cno));
		} else {
			$sql .= ' AND zy = ?';
			$data = $this->db->getRow($sql, array($year, $term, $cno, $speciality));
		}

		return has($data) ? (ceil($data['jhrs'] * $ratio) <= $data['rs']) : false;
	}

}
