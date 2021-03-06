<?php

/**
 * 课程类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
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
	 * 检测是否允许选课
	 * @return boolean 可以选课为TRUE，否则为FALSE
	 */
	private function _check() {
		if (!$this->model->isOpen()) {
			Error::display('现在未开放选课，不允许选课');
		}
		if ($this->_student->isUnpaid($this->session->get('username'))) {
			Error::display('请交清费用再进行选课');
		}

		// 是否限制选课时间
		$now   = date('Y-m-d H:i:s');
		$allow = $this->model->isAllowedCourse($now, $this->session->get('grade'), $this->session->get('system'));
		if (!$allow) {
			Error::display('现在未到选课时间，不允许选课');
		}

		return $allow;
	}

	/**
	 * 获取当前学生可选课程表
	 * @param  string $type 课程类型
	 * @param  string $status 课程状态
	 * @return mixed       可选课程数据
	 */
	protected function listing($type) {
		$title = Config::get('course.type.' . $type . '.name');
		$code  = Config::get('course.type.' . $type . '.code');

		$this->_check();

		// 是否通识素质课
		if ($this->model->isGeneralCourse($code)) {
			// 是否允许选择通识素质课
			if (!$this->model->isGeneralOpen()) {
				Error::display('现在未开放通识素质课选课，不允许选课');
			}

			// 是否限制选择通识素质课
			$now          = date('Y-m-d H:i:s');
			$generalCount = Config::get('course.general.unlimited');
			$generalRatio = Config::get('course.general.unlimited');
			$allow        = $this->model->isAllowedGeneralCourse($now, $this->session->get('grade'), $this->session->get('system'), $generalCount, $generalRatio);
			if (!$allow) {
				Error::display('现在未到通识素质课选课时间，不允许选课');
			}
		}

		list($property, $platform) = array_pad(str_split($code), 2, '');
		if ($this->model->isSpecializedCourse($code)) {
			if (isEmpty($platform) && 'B' == $property) {
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
		} elseif ($this->model->isGeneralCourse($code)) {
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

		return $this->view->display('course.listing', array('courses' => $coursesByCampus, 'title' => $title, 'type' => $type));
	}

	/**
	 * 检索课程
	 * @param  string $type 检索类型
	 * @return array          课程数组
	 */
	protected function search($type) {
		$title = Config::get('course.type.' . $type . '.name');
		$code  = Config::get('course.type.' . $type . '.code');

		$this->_check();

		// 是否允许选择其他课程
		if ($this->model->isOtherCourse($code)) {
			if (!$this->model->isOthersOpen()) {
				Error::display('现在未到其他课程选课时间，不允许选课');
			}
		}

		$grades          = $this->model->getGrades($this->session->get('year'), $this->session->get('term'));
		$colleges        = $this->model->getColleges();
		$specialities    = $this->model->getSpecialities();
		$coursesByCampus = array();
		if (isPost()) {
			$_POST      = sanitize($_POST);
			$keyword    = $_POST['keyword'];
			$grade      = '*' == $_POST['grade'] ? null : $_POST['grade'];
			$speciality = '*' == $_POST['speciality'] ? null : $_POST['speciality'];
			$cno        = null;
			$cname      = null;
			if (isAlphaNumber($keyword)) {
				$cno = strtoupper($keyword);
			} else {
				$cname = $keyword;
			}

			$property = null;
			if ($this->model->isOtherCourse($code)) {
				$property = 'others';
			}

			$courses = $this->model->listCourse(
				$this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('season'),
				$this->session->get('username'),
				null, $property, $grade, $speciality, $cno, $cname);

			foreach ($courses as $course) {
				if (isEmpty($course['xqh'])) {
					$coursesByCampus['unknown'][$course['kcxh']][] = $course;
				} else {
					$coursesByCampus[$course['xqh']][$course['kcxh']][] = $course;
				}
			}
			krsort($coursesByCampus);
		}

		return $this->view->display('course.search', array('courses' => $coursesByCampus, 'title' => $title, 'type' => $type, 'grades' => $grades, 'colleges' => $colleges, 'specialities' => $specialities));
	}

	/**
	 * 选择课程
	 *
	 * @return boolean       选课成功为TRUE，不成功为FALSE
	 */
	protected function select() {
		$this->_check();

		if (isPost()) {
			$_POST = sanitize($_POST);

			$cno     = $_POST['course'];
			$checked = $_POST['checked'];
			$type    = $_POST['type'];
			$code    = Config::get('course.type.' . $type . '.code');

			// 是否通识素质课
			if ($this->model->isGeneralCourse($code)) {
				// 是否允许选择通识素质课
				if (!$this->model->isGeneralOpen()) {
					Error::display('现在未开放通识素质课选课，不允许选课');
				}

				// 是否限制选择通识素质课
				$now          = date('Y-m-d H:i:s');
				$generalCount = Config::get('course.general.unlimited');
				$generalRatio = Config::get('course.general.unlimited');
				$allow        = $this->model->isAllowedGeneralCourse($now, $this->session->get('grade'), $this->session->get('system'), $generalCount, $generalRatio);
				if (!$allow) {
					Error::display('现在未到通识素质课选课时间，不允许选课');
				}
			}

			if ('true' == $checked) {
				if ($this->model->isGeneralCourse($code)) {
					if ($this->model->isExceedCourseLimit(
						$this->session->get('year'),
						$this->session->get('term'),
						$this->session->get('username'),
						$generalCount)) {
						Error::display('已选通识素质课已达限制门数，不允许选课');
					} elseif (Config::get('course.general.unlimited') < $generalRatio) {
						if ($this->model->isFull($this->session->get('year'), $this->session->get('term'), $cno, $generalRatio)) {
							Error::display('该门课程选课人数超限，不允许选课');
						}
					}
				}

				$this->model->select(
					$this->session->get('year'),
					$this->session->get('term'),
					$this->session->get('season'),
					$this->session->get('username'),
					$this->session->get('name'),
					$this->session->get('grade'),
					$this->session->get('spno'),
					$cno);
			} else {
				$this->model->drop(
					$this->session->get('year'),
					$this->session->get('term'),
					$this->session->get('username'),
					$cno);
			}

			return isset($type) ? redirect('course.listing', $type) : redirect('course.current');
		}
	}

	/**
	 * 选课申请
	 * @param string $type 课程类型
	 * @param string $cno 课程序号
	 * @return NULL
	 */
	protected function apply($type, $cno) {
		$title = Config::get('course.type.' . $type . '.name');
		$code  = Config::get('course.type.' . $type . '.code');

		$this->_check();

		if (isPost()) {
			$_POST = sanitize($_POST);

			if ($this->model->isOtherCourse($code)) {
				// 是否允许选择其他课程
				if (!$this->model->isOthersOpen()) {
					Error::display('现在未到其他课程选课时间，不允许选课');
				}

				// 申请其他课程
				$this->model->apply(
					$this->session->get('year'),
					$this->session->get('term'),
					$this->session->get('username'),
					$this->session->get('name'),
					sanitize($cno),
					Config::get('course.apply.others'));
			} elseif ($this->model->isRetakeCourse($code)) {
				// 申请重修
				$this->model->apply(
					$this->session->get('year'),
					$this->session->get('term'),
					$this->session->get('username'),
					$this->session->get('name'),
					sanitize($cno),
					Config::get('course.apply.retake'),
					$_POST['lyear'],
					$_POST['lterm'],
					$_POST['lcno'],
					$_POST['lcredit']);
			}

			return redirect('course.process');
		}

		if ($this->model->isRetakeCourse($code)) {
			$course = $this->model->getRetakableCourse($this->session->get('username'), $this->session->get('year'), $this->session->get('term'));

			return $this->view->display('course.apply', array('type' => $type, 'cno' => $cno, 'title' => $title, 'lcnos' => $course['cnos']));
		}

		return $this->view->display('course.apply', array('type' => $type, 'cno' => $cno, 'title' => $title));
	}

	/**
	 * 撤销选课申请
	 * @return void
	 */
	protected function revoke() {
		if (isPost()) {
			$_POST = sanitize($_POST);
			$cno   = $_POST['cno'];

			$this->model->revoke($this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('username'),
				$cno);
		}

		return redirect('course.process');
	}

	/**
	 * 列出当前学生的课程申请列表
	 * @return array 课程申请列表
	 */
	protected function process() {
		$courses = $this->model->getApplications($this->session->get('username'));

		return $this->view->display('course.process', array('courses' => $courses));
	}

	/**
	 * 列出当前学生当前年度、学期可退选课程表
	 * @return void
	 */
	protected function current() {
		$this->_check();

		$courses         = $this->model->getTimetable($this->session->get('year'), $this->session->get('term'), $this->session->get('username'));
		$coursesByNumber = array();
		foreach ($courses as $course) {
			$coursesByNumber[$course['kcxh']][] = $course;
		}

		return $this->view->display('course.current', array('courses' => $coursesByNumber));
	}

	/**
	 * 选课时间冲突检测
	 * @param  string $cno 课程序号
	 * @return mixed 冲突为冲突课程序号数组，否则为FALSE
	 */
	protected function clash($cno) {
		$status = $this->model->isClash(
			$this->session->get('year'),
			$this->session->get('term'),
			$this->session->get('username'),
			$cno);

		echo json_encode(array('status' => $status));
		return $status;
	}

	/**
	 * 判断是否选课人数已满
	 * @param  string $cno 课程序号
	 * @param string $type 课程类型
	 * @return boolean         人数已满为TRUE，未满为FALSE
	 */
	protected function full($cno, $type) {
		$code = Config::get('course.type.' . $type . 'code');

		if ($this->model->isGeneralCourse($code)) {
			$status = $this->model->isFull($this->session->get('year'),
				$this->session->get('term'),
				$cno);
		} else {
			$status = $this->model->isFull($this->session->get('year'),
				$this->session->get('term'),
				$cno,
				$this->session->get('spno'));
		}

		echo json_encode(array('status' => $status));
		return $status;
	}

}
