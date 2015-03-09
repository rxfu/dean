<?php

/**
 * 课程类
 */
class CourseController extends StudentAdminController {

	/**
	 * 学生模型对象
	 * @var object
	 */
	private $_student;

	/**
	 * 继承自基类构造函数
	 */
	public function __construct() {
		parent::__construct();

		$this->_student = new StudentModel();
	}

	/**
	 * 获取当前学生可选课程表
	 * @param  string $type 课程类型
	 * @param  string $status 课程状态
	 * @return mixed       可选课程数据
	 */
	protected function course($type) {
		$title = Config::get('course.type.' . $type . '.name');
		$type  = Config::get('course.type.' . $type . '.code');

		if (!$this->model->isOpen()) {
			$this->session->put('error', '现在未开放选课，不允许选课');
			return redirect('error.error');
		}
		if ($this->_student->isUnpaid($this->session->get('username'))) {
			$this->session->put('error', '请交清费用再进行选课');
			return redirect('error.error');
		}

		// 是否限制选课时间
		$now   = date('Y-m-d H:i:s');
		$allow = $this->model->isAllowedCourse($now, $this->session->get('grade'), $this->session->get('system'));
		if (!$allow) {
			$this->session->put('error', '现在未到选课时间，不允许选课');
			return redirect('error.error');
		}

		// 是否通识素质课
		if ($this->model->isGeneralCourse($type)) {
			// 是否允许选择通识素质课
			if (!$this->model->isGeneralOpen()) {
				$this->session->put('error', '现在未开放通识素质课选课，不允许选课');
				return redirect('error.error');
			}

			// 是否限制选择通识素质课
			$generalCount = Config::get('course.general.unlimited');
			$generalRatio = Config::get('course.general.unlimited');
			$allow        = $this->model->isAllowedGeneralCourse($now, $this->session->get('grade'), $this->session->get('system'), $generalCount, $generalRatio);
			if (!$allow) {
				$this->session->put('error', '现在未到通识素质课选课时间，不允许选课');
				return redirect('error.error');
			}
		}

		list($property, $platform) = array_pad(str_split($type), 2, '');
		if ($this->model->isSpecializedCourse($type)) {
			if (isEmpty($platform) && 'b' == $property) {
				$platforms = Dictionary::getAll('pt');
				$platforms = array_column($platforms, 'dm');
				$platform  = array_values(array_diff($platforms, array('', 'T')));
			}

			$courses = $this->model->listCourse(
				$this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('season'),
				$this->session->get('username'),
				$platform,
				$property,
				$this->session->get('grade'),
				$this->session->get('spno'));
		} elseif ($this->model->isGeneralCourse($type)) {
			$courses = $this->model->listCourse(
				$this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('season'),
				$this->session->get('username'),
				$platform,
				$property);

			if ($this->model->isExceedCourseLimit(
				$this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('username'),
				$generalCount)) {
				array_walk($courses, function (&$course) {
					$course['zt'] = Config::get('course.select.selectable') == $course['zt'] ? Config::get('course.select.forbidden') : $course['zt'];
				});
			} elseif (Config::get('course.general.unlimited') < $generalRatio) {
				array_walk($courses, function (&$course) use ($generalRatio) {
					if (ceil($course['jhrs'] * $generalRatio) <= $course['rs']) {
						$course['zt'] = Config::get('course.select.selectable') == $course['zt'] ? Config::get('course.select.forbidden') : $course['zt'];
					}
				});
			}
		}

		$coursesByCampus = array();
		foreach ($courses as $course) {
			if (isEmpty($course['xqh'])) {
				$coursesByCampus['unknown'][$course['kcxh']][] = $course;
			} else {
				$coursesByCampus[$course['xqh']][$course['kcxh']][] = $course;
			}
		}
		krsort($coursesByCampus);

		return $this->view->display('course.course', array('courses' => $coursesByCampus, 'title' => $title, 'type' => $type));
	}

	/**
	 * 检索课程
	 * @param  string $type 检索类型
	 * @return array          课程数组
	 */
	protected function search($type) {
		if (!$this->isOpen()) {
			$this->session->put('error', '现在未到选课时间，不允许选课');
			return redirect('error.error');
		}
		if ($this->isUnpaid($this->session->get('username'))) {
			$this->session->put('error', '请交清费用再进行选课');
			return redirect('error.error');
		}

		// 是否限制选课时间
		$now = date('Y-m-d H:i:s');
		if ($this->isLimitCourseTime()) {
			$sql  = 'SELECT * FROM t_xk_sjxz WHERE xz = ? AND nj = ?';
			$data = $this->db->getAll($sql, array($this->session->get('system'), $this->session->get('grade')));

			$allow = true;
			if (FALSE !== $data && !empty($data)) {
				$allow = false;
				foreach ($data as $limit) {
					if ($now >= $limit['kssj'] && $now <= $limit['jssj']) {
						$allow = true;
						break;
					}
				}
			}

			if (!$allow) {
				$this->session->put('error', '现在未到选课时间，不允许选课');
				return redirect('error.error');
			}
		}

		// 是否允许选择其他课程
		if (Config::get('course.type.others') == $type && !$this->isOthersOpen()) {
			$this->session->put('error', '现在未到其他课程选课时间，不允许选课');
			return redirect('error.error');
		}

		$cno     = null;
		$cname   = null;
		$courses = array();
		if (isPost()) {
			$keyword = $_POST['keyword'];
			if (isAlphaNumber($keyword)) {
				$cno = strtoupper($keyword);
			} else {
				$cname = $keyword;
			}

			switch ($type) {
				case Config::get('course.type.others'):
					$grade      = '*';
					$speciality = '*';

					$data = $this->db->getAll('SELECT dm FROM t_zd_pt');
					foreach ($data as $pt) {
						if (!isEmpty($pt['dm'])) {
							$platform[] = $pt['dm'];
						}
					}

					$data = $this->db->getAll('SELECT dm FROM t_zd_xz');
					foreach ($data as $xz) {
						if (isset($platform) && (isEmpty($xz['dm']) || in_array(array_map(
							function ($pt) use ($xz) {
								return $pt . $xz['dm'];
							}
							, $platform), array($this->codes[Config::get('course.type.humanity')]['code'], $this->codes[Config::get('course.type.natural')]['code'], $this->codes[Config::get('course.type.art')]['code'], $this->codes[Config::get('course.type.special')]['code'])))) {
							continue;
						}

						$property[] = $xz['dm'];
					}

					break;

				case Config::get('course.type.retake'):
					$grade      = '*';
					$speciality = '*';
					$platform   = '*';
					$property   = '*';
					break;

				default:
					break;
			}

			if (isset($grade) && isset($speciality) && isset($platform) && isset($property)) {
				$param = "'" . implode("','", array($this->session->get('season'), $this->session->get('username'), $this->session->get('year'), $this->session->get('term'), array_to_pg($platform), array_to_pg($property), array_to_pg($grade), array_to_pg($speciality), $cno, $cname)) . "'";
				$data  = $this->db->query('SELECT * FROM p_kxkcb_sel(' . $param . ')');

				$courses = array();
				foreach ($data as $course) {
					if (isEmpty($course['xqh'])) {
						$courses['unknown'][$course['kcxh']][] = $course;
					} else {
						$courses[$course['xqh']][$course['kcxh']][] = $course;
					}
				}
				krsort($courses);
			}
		}

		return $this->view->display('course.search', array('type' => $type, 'courses' => $courses, 'title' => $this->codes[$type]['name'], 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term'), 'campus' => $this->session->get('campus')));
	}

	/**
	 * 选择课程
	 *
	 * @return boolean       选课成功为TRUE，不成功为FALSE
	 */
	protected function select() {
		if (!$this->isOpen()) {
			$this->session->put('error', '现在未到选课时间，不允许选课');
			return redirect('error.error');
		}
		if ($this->isUnpaid($this->session->get('username'))) {
			$this->session->put('error', '请交清费用再进行选课');
			return redirect('error.error');
		}

		// 是否限制选课时间
		$now = date('Y-m-d H:i:s');
		if ($this->isLimitCourseTime()) {
			$sql  = 'SELECT * FROM t_xk_sjxz WHERE xz = ? AND nj = ?';
			$data = $this->db->getAll($sql, array($this->session->get('system'), $this->session->get('grade')));

			$allow = true;
			if (FALSE !== $data && !empty($data)) {
				$allow = false;
				foreach ($data as $limit) {
					if ($now >= $limit['kssj'] && $now <= $limit['jssj']) {
						$allow = true;
						break;
					}
				}
			}

			if (!$allow) {
				$this->session->put('error', '现在未到选课时间，不允许选课');
				return redirect('error.error');
			}
		}

		if (isPost()) {
			// 是否允许选择通识素质课
			if (!$this->isGeneralOpen()) {
				if (in_array($this->codes[$type]['code'], array($this->codes[Config::get('course.type.humanity')]['code'], $this->codes[Config::get('course.type.natural')]['code'], $this->codes[Config::get('course.type.art')]['code'], $this->codes[Config::get('course.type.special')]['code']))) {
					$this->session->put('error', '现在未到通识素质课选课时间，不允许选课');
					return redirect('error.error');
				}
			}

			// 是否限制选择通识素质课
			$limitCourse = Config::get('course.general.unlimited');
			$limitRatio  = Config::get('course.general.unlimited');
			if ($this->isLimitGeneral()) {
				$sql  = 'SELECT * FROM t_xk_tsxz WHERE xz = ? AND nj = ?';
				$data = $this->db->getAll($sql, array($this->session->get('system'), $this->session->get('grade')));

				if (FALSE !== $data && !empty($data)) {
					$allow = false;
					foreach ($data as $limit) {
						if ($now >= $limit['kssj'] && $now <= $limit['jssj']) {
							$allow       = true;
							$limitCourse = $limit['ms'];
							$limitRatio  = $limit['bl'] / 100;
							break;
						}
					}

					if (!$allow) {
						$this->session->put('error', '现在未到通识素质课选课时间，不允许选课');
						return redirect('error.error');
					}
				}
			}

			$_POST = sanitize($_POST);

			$cno     = $_POST['course'];
			$checked = $_POST['checked'];
			$type    = $_POST['type'];

			if ('true' == $checked) {
				if (in_array($this->codes[$type]['code'], array($this->codes[Config::get('course.type.humanity')]['code'], $this->codes[Config::get('course.type.natural')]['code'], $this->codes[Config::get('course.type.art')]['code'], $this->codes[Config::get('course.type.special')]['code']))) {
					// 限制通识素质课选课人数
					if (Config::get('course.general.unlimited') < $limitRatio) {
						$course['jhrs'] = ceil($course['jhrs'] * $limitRatio);

						if ($course['rs'] >= $course['jhrs']) {
							$this->session->put('error', '该门课程选课人数超限，不允许选课');
							return redirect('error.error');
						}
					}

					// 限制通识素质课门数
					if (Config::get('course.general.unlimited') < $limitCourse) {
						$sql         = 'SELECT ms FROM v_xk_tssztj WHERE nd = ? AND xq = ? AND xh = ?';
						$courseCount = $this->db->getColumn($sql, array($this->session->get('year'), $this->session->get('term'), $this->session->get('username')));

						if ($limitCourse <= $courseCount) {
							$this->session->put('error', '已选通识素质课已达限制门数，不允许选课');
							return redirect('error.error');
						}
					}
				}

				$param = "'" . implode("','", array($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $cno, $this->session->get('name'), $this->session->get('grade'), $this->session->get('spno'), $this->session->get('season'))) . "'";

				$selected = $this->db->query('SELECT p_xzkc_save(' . $param . ')');
				if ($selected) {
					Logger::write(array('xh' => $this->session->get('username'), 'kcxh' => $cno, 'czlx' => Config::get('log.select')));
					echo 'success';
				} else {
					echo 'failed';
				}
			} else {
				$param = "'" . implode("','", array($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $cno)) . "'";

				$deleted = $this->db->query('SELECT p_scxk_del(' . $param . ')');
				if ($deleted) {
					Logger::write(array('xh' => $this->session->get('username'), 'kcxh' => $cno, 'czlx' => Config::get('log.drop')));
					echo 'success';
				} else {
					echo 'failed';
				}
			}

			return isset($type) ? redirect('course.course', $type) : redirect('course.current');
		}
	}

	/**
	 * 选课时间冲突检测
	 * @param  string $course 课程序号
	 * @return mixed 冲突为冲突课程序号数组，否则为FALSE
	 */
	protected function clash($course) {
		$collision = false;

		$sql      = 'SELECT kcxh, ksz, jsz, zc, ksj, jsj FROM t_pk_kb WHERE nd = ? AND xq = ? AND kcxh = ?';
		$currents = $this->db->getAll($sql, array($this->session->get('year'), $this->session->get('term'), $course));

		$sql      = 'SELECT kcxh, ksz, jsz, zc, ksj, jsj FROM v_xk_xskcb WHERE xh = ? AND nd = ? AND xq = ?';
		$compares = $this->db->getAll($sql, array($this->session->get('username'), $this->session->get('year'), $this->session->get('term')));

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

		$status = $collision;

		echo json_encode(array('status' => $status));
		return $status;
	}

	/**
	 * 判断是否选课人数已满
	 * @param  string $course 课程序号
	 * @return boolean         人数已满为TRUE，未满为FALSE
	 */
	protected function full($course) {
		$sql    = 'SELECT jhrs, rs FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		$data   = $this->db->getRow($sql, array($this->session->get('year'), $this->session->get('term'), $course));
		$status = 0 < $data['jhrs'] && $data['jhrs'] < $data['rs'];

		echo json_encode(array('status' => $status));
		return $status;
	}

	/**
	 * 选课申请
	 * @param string $type 课程类型
	 * @param string $cno 课程序号
	 * @return NULL
	 */
	protected function apply($type, $cno) {
		if (!$this->isOpen()) {
			$this->session->put('error', '现在未到选课时间，不允许选课');
			return redirect('error.error');
		}
		if ($this->isUnpaid($this->session->get('username'))) {
			$this->session->put('error', '请交清费用再进行选课');
			return redirect('error.error');
		}

		// 是否限制选课时间
		$now = date('Y-m-d H:i:s');
		if ($this->isLimitCourseTime()) {
			$sql  = 'SELECT * FROM t_xk_sjxz WHERE xz = ? AND nj = ?';
			$data = $this->db->getAll($sql, array($this->session->get('system'), $this->session->get('grade')));

			$allow = true;
			if (FALSE !== $data && !empty($data)) {
				$allow = false;
				foreach ($data as $limit) {
					if ($now >= $limit['kssj'] && $now <= $limit['jssj']) {
						$allow = true;
						break;
					}
				}
			}

			if (!$allow) {
				$this->session->put('error', '现在未到选课时间，不允许选课');
				return redirect('error.error');
			}
		}

		if (isPost()) {
			// 是否允许选择其他课程
			if (Config::get('course.type.others') == $type && !$this->isOthersOpen()) {
				$this->session->put('error', '现在未到其他课程选课时间，不允许选课');
				return redirect('error.error');
			}

			$_POST = sanitize($_POST);

			if (Config::get('course.type.retake') == $type) {
				$data['ynd']   = $_POST['lyear'];
				$data['yxq']   = $_POST['lterm'];
				$data['ykcxh'] = $_POST['lcno'];
				$data['xklx']  = Config::get('course.apply.retake');
			} elseif (Config::get('course.type.others') == $type) {
				$data['xklx'] = Config::get('course.apply.others');
			}
			$data['xh']   = $this->session->get('username');
			$data['xm']   = $this->session->get('name');
			$data['nd']   = $this->session->get('year');
			$data['xq']   = $this->session->get('term');
			$data['kcxh'] = sanitize($cno);
			$data['xksj'] = date('Y-m-d H:i:s');

			$sql          = 'SELECT kch, pt, xz, kkxy FROM v_xk_kxkcxx WHERE kcxh = ? AND nd = ? AND xq = ?';
			$course       = $this->db->getRow($sql, array($data['kcxh'], $this->session->get('year'), $this->session->get('term')));
			$data['kch']  = $course['kch'];
			$data['pt']   = $course['pt'];
			$data['xz']   = $course['xz'];
			$data['kkxy'] = $course['kkxy'];
			$this->db->insertRecord('t_xk_xksq', $data);

			Logger::write(array('xh' => $this->session->get('username'), 'kcxh' => $data['kcxh'], 'czlx' => Config::get('log.apply_course')));

			return redirect('course.process');
		}

		if (Config::get('course.type.retake') == $type) {
			$sql    = 'SELECT DISTINCT nd FROM t_xk_xkxx WHERE xh = ?';
			$lyears = $this->db->getAll($sql, array($this->session->get('username')));

			$lterms = Dictionary::getAll('xq');

			$sql   = 'SELECT DISTINCT kcxh, kcmc FROM v_xk_xskcb WHERE xh = ? ORDER BY kcxh';
			$lcnos = $this->db->getAll($sql, array($this->session->get('username')));

			return $this->view->display('course.apply', array('type' => $type, 'cno' => $cno, 'title' => $this->codes[$type]['name'], 'lyears' => $lyears, 'lterms' => $lterms, 'lcnos' => $lcnos, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
		}
		return $this->view->display('course.apply', array('type' => $type, 'cno' => $cno, 'title' => $this->codes[$type]['name'], 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

	/**
	 * 列出当前学生的课程申请列表
	 * @return array 课程申请列表
	 */
	protected function process() {
		$data = $this->db->searchRecord('t_xk_xksq', array('xh' => $this->session->get('username')));
		return $this->view->display('course.process', array('courses' => $data, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

	/**
	 * 列出当前学生当前年度、学期可退选课程表
	 * @return void
	 */
	protected function current() {
		if (!$this->isOpen()) {
			$this->session->put('error', '现在未到选课时间，不允许选课');
			return redirect('error.error');
		}
		if ($this->isUnpaid($this->session->get('username'))) {
			$this->session->put('error', '请交清费用再进行选课');
			return redirect('error.error');
		}

		// 是否限制选课时间
		$now = date('Y-m-d H:i:s');
		if ($this->isLimitCourseTime()) {
			$sql  = 'SELECT * FROM t_xk_sjxz WHERE xz = ? AND nj = ?';
			$data = $this->db->getAll($sql, array($this->session->get('system'), $this->session->get('grade')));

			$allow = true;
			if (FALSE !== $data && !empty($data)) {
				$allow = false;
				foreach ($data as $limit) {
					if ($now >= $limit['kssj'] && $now <= $limit['jssj']) {
						$allow = true;
						break;
					}
				}
			}

			if (!$allow) {
				$this->session->put('error', '现在未到选课时间，不允许选课');
				return redirect('error.error');
			}
		}

		$data = $this->db->searchRecord('v_xk_xskcb', array('xh' => $this->session->get('username'), 'nd' => $this->session->get('year'), 'xq' => $this->session->get('term')));

		$courses = array();
		foreach ($data as $course) {
			$courses[$course['kcxh']][] = $course;
		}

		return $this->view->display('course.current', array('courses' => $courses, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

}
