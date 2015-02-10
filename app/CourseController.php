<?php

/**
 * 课程类
 */
class CourseController extends StudentAdminController {

	/**
	 * 课程平台性质对应代码表
	 * @var array
	 */
	protected $codes = array(
		BASIC    => array(
			'code' => 'BT',
			'name' => '公共',
		),
		REQUIRED => array(
			'code' => 'B',
			'name' => '必修',
		),
		ELECTIVE => array(
			'code' => 'X',
			'name' => '选修',
		),
		HUMANITY => array(
			'code' => 'WT',
			'name' => '人文社科通识素质',
		),
		NATURAL  => array(
			'code' => 'IT',
			'name' => '自然科学通识素质',
		),
		ART      => array(
			'code' => 'YT',
			'name' => '艺术体育通识素质',
		),
		SPECIAL  => array(
			'code' => 'QT',
			'name' => '其他专项通识素质',
		),
		OTHERS   => array(
			'code' => 'OTHERS',
			'name' => '其他课程',
		),
		RETAKE   => array(
			'code' => 'RETAKE',
			'name' => '重修',
		),
	);

	/**
	 * 继承自基类before函数
	 * @return NULL
	 */
	protected function before() {
		parent::before();

		

		if ($this->unpaid()) {
			return redirect('student.unpaid');
		}
	}

	/**
	 * 禁止学生选课
	 * @return void
	 */
	protected function forbidden() {
		return $this->view->display('course.forbidden');
	}

	/**
	 * 判断当前学生是否欠费
	 *
	 * @return boolean     欠费为TRUE，未欠费为FALSE
	 */
	protected function unpaid() {
		$sql  = 'SELECT xh FROM t_xk_xsqf WHERE xh = ?';
		$data = DB::getInstance()->getRow($sql, Session::get('username'));

		return strcasecmp($data['xh'], Session::get('username')) ? false : true;
	}

	/**
	 * 获取当前学生可选课程表
	 * @param  string $type 课程类型
	 * @param  string $status 课程状态
	 * @return mixed       可选课程数据
	 */
	protected function index($type) {
		list($property, $platform) = array_pad(str_split($this->codes[$type]['code']), 2, '');

		if (in_array($property . $platform, array($this->codes[BASIC]['code'], $this->codes[REQUIRED]['code'], $this->codes[ELECTIVE]['code']))) {
			$grade      = Session::get('grade');
			$speciality = Session::get('spno');
		} else {
			$sql  = 'SELECT DISTINCT nj FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND zsjj = ?';
			$data = DB::getInstance()->getAll($sql, array(Session::get('year'), Session::get('term'), Session::get('season')));
			foreach ($data as $g) {
				if (!isEmpty($g['nj'])) {
					$grade[] = $g['nj'];
				}
			}

			$sql  = 'SELECT DISTINCT zy FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND zsjj = ?';
			$data = DB::getInstance()->getAll($sql, array(Session::get('year'), Session::get('term'), Session::get('season')));
			foreach ($data as $sp) {
				if (!isEmpty($sp['zy'])) {
					$speciality[] = $sp['zy'];
				}
			}
		}

		if (isEmpty($platform)) {
			$data = DB::getInstance()->getAll('SELECT dm FROM t_zd_pt');
			foreach ($data as $pt) {
				if (isEmpty($pt['dm']) || in_array($property . $pt['dm'], array_column($this->codes, 'code'))) {
					continue;
				}
				$platform[] = $pt['dm'];
			}
		}

		$param = "'" . implode("','", array(Session::get('season'), Session::get('username'), Session::get('year'), Session::get('term'), array_to_pg($platform), array_to_pg($property), array_to_pg($grade), array_to_pg($speciality))) . "'";
		$data  = DB::getInstance()->query('SELECT * FROM p_kxkcb_sel(' . $param . ', null, null)');

		$courses = array();
		foreach ($data as $course) {
			if (isEmpty($course['xqh'])) {
				$courses['unknown'][$course['kcxh']][] = $course;
			} else {
				$courses[$course['xqh']][$course['kcxh']][] = $course;
			}
		}
		krsort($courses);

		return $this->view->display('course.index', array('courses' => $courses, 'title' => $this->codes[$type]['name'], 'type' => $type));
	}

	/**
	 * 检索课程
	 * @param  string $type 检索类型
	 * @return array          课程数组
	 */
	protected function search($type) {
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
				case OTHERS:
					$grade      = '*';
					$speciality = '*';

					$data = DB::getInstance()->getAll('SELECT dm FROM t_zd_pt');
					foreach ($data as $pt) {
						if (!isEmpty($pt['dm'])) {
							$platform[] = $pt['dm'];
						}
					}

					$data = DB::getInstance()->getAll('SELECT dm FROM t_zd_xz');
					foreach ($data as $xz) {
						if (isset($platform) && (isEmpty($xz['dm']) || in_array(array_map(
							function ($pt) use ($xz) {
								return $pt . $xz['dm'];
							}
							, $platform), array($this->codes[HUMANITY]['code'], $this->codes[NATURAL]['code'], $this->codes[ART]['code'], $this->codes[SPECIAL]['code'])))) {
							continue;
						}

						$property[] = $xz['dm'];
					}

					break;

				case RETAKE:
					$grade      = '*';
					$speciality = '*';
					$platform   = '*';
					$property   = '*';
					break;

				default:
					break;
			}

			if (isset($grade) && isset($speciality) && isset($platform) && isset($property)) {
				$param = "'" . implode("','", array(Session::get('season'), Session::get('username'), Session::get('year'), Session::get('term'), array_to_pg($platform), array_to_pg($property), array_to_pg($grade), array_to_pg($speciality), $cno, $cname)) . "'";
				$data  = DB::getInstance()->query('SELECT * FROM p_kxkcb_sel(' . $param . ')');

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

		return $this->view->display('course.search', array('type' => $type, 'courses' => $courses, 'title' => $this->codes[$type]['name']));
	}

	/**
	 * 选择课程
	 *
	 * @return boolean       选课成功为TRUE，不成功为FALSE
	 */
	protected function select() {
		if (isPost()) {
			$_POST = sanitize($_POST);

			$cno     = $_POST['course'];
			$checked = $_POST['checked'];
			$type    = $_POST['type'];

			if ('true' == $checked) {
				$param = "'" . implode("','", array(Session::get('year'), Session::get('term'), Session::get('username'), $cno, Session::get('name'), Session::get('grade'), Session::get('spno'), Session::get('season'))) . "'";

				$selected = DB::getInstance()->query('SELECT p_xzkc_save(' . $param . ')');
				if ($selected) {
					Logger::write(array('xh' => Session::get('username'), 'kcxh' => $cno, 'czlx' => LOG_INSERT));
					echo 'success';
				} else {
					echo 'failed';
				}
			} else {
				$param = "'" . implode("','", array(Session::get('year'), Session::get('term'), Session::get('username'), $cno)) . "'";

				$deleted = DB::getInstance()->query('SELECT p_scxk_del(' . $param . ')');
				if ($deleted) {
					Logger::write(array('xh' => Session::get('username'), 'kcxh' => $cno, 'czlx' => LOG_DELETE));
					echo 'success';
				} else {
					echo 'failed';
				}
			}

			return Redirect::to('course.index.' . $type);
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
		$currents = DB::getInstance()->getAll($sql, array(Session::get('year'), Session::get('term'), $course));

		$sql      = 'SELECT kcxh, ksz, jsz, zc, ksj, jsj FROM v_xk_xskcb WHERE xh = ? AND nd = ? AND xq = ?';
		$compares = DB::getInstance()->getAll($sql, array(Session::get('username'), Session::get('year'), Session::get('term')));

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
		$sql    = 'SELECT jhrs, rs FROM t_xk_tj WHERE kcxh = ?';
		$data   = DB::getInstance()->getRow($sql, $course);
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
		if (isPost()) {
			$_POST = sanitize($_POST);

			if (RETAKE == $type) {
				$data['ynd']   = $_POST['lyear'];
				$data['yxq']   = $_POST['lterm'];
				$data['ykcxh'] = $_POST['lcno'];
				$data['xklx']  = APPLY_RETAKE;
			} elseif (OTHERS == $type) {
				$data['xklx'] = APPLY_OTHERS;
			}
			$data['xh']   = Session::get('username');
			$data['xm']   = Session::get('name');
			$data['nd']   = Session::get('year');
			$data['xq']   = Session::get('term');
			$data['kcxh'] = $cno;
			$data['xksj'] = date('Y-m-d H:i:s');

			$sql          = 'SELECT kch, pt, xz, kkxy FROM v_xk_kxkcxx WHERE kcxh = ? AND nd = ? AND xq = ?';
			$course       = DB::getInstance()->getRow($sql, array($cno, Session::get('year'), Session::get('term')));
			$data['kch']  = $course['kch'];
			$data['pt']   = $course['pt'];
			$data['xz']   = $course['xz'];
			$data['kkxy'] = $course['kkxy'];
			DB::getInstance()->insertRecord('t_xk_xksq', $data);

			Logger::write(array('xh' => Session::get('username'), 'kcxh' => $data['kcxh'], 'czlx' => LOG_APPLY));

			return Redirect::to('course.process');
		}

		if (RETAKE == $type) {
			$sql    = 'SELECT DISTINCT nd FROM t_xk_xkxx WHERE xh = ?';
			$lyears = DB::getInstance()->getAll($sql, array(Session::get('username')));

			$lterms = Dictionary::getAll('xq');

			$sql   = 'SELECT DISTINCT kcxh, kcmc FROM v_xk_xskcb WHERE xh = ? ORDER BY kcxh';
			$lcnos = DB::getInstance()->getAll($sql, array(Session::get('username')));

			return $this->view->display('course.apply', array('type' => $type, 'cno' => $cno, 'title' => $this->codes[$type]['name'], 'lyears' => $lyears, 'lterms' => $lterms, 'lcnos' => $lcnos));
		}
		return $this->view->display('course.apply', array('type' => $type, 'cno' => $cno, 'title' => $this->codes[$type]['name']));
	}

	/**
	 * 列出当前学生的课程申请列表
	 * @return array 课程申请列表
	 */
	protected function process() {
		$data = DB::getInstance()->searchRecord('t_xk_xksq', array('xh' => Session::get('username')));
		return $this->view->display('course.process', array('courses' => $data));
	}

}
