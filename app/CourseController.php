<?php

/**
 * 课程类
 */
class CourseController extends Controller {

	/**
	 * 课程平台性质对应代码表
	 * @var array
	 */
	protected $codes = array(
		BASIC => array(
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
		HUMANITY  => array(
			'code' => 'WT',
			'name' => '人文社科通识素质',
		),
		NATURAL  => array(
			'code' => 'IT',
			'name' => '自然科学通识素质',
		),
		ART  => array(
			'code' => 'XT',
			'name' => '艺术体育通识素质',
		),
		SPECIAL  => array(
			'code' => 'QT',
			'name' => '其他专项通识素质',
		),
		OTHERS => array(
			'code' => 'OTHERS',
			'name' => '其他课程',
			),
		RETAKE => array(
			'code'=>'RETAKE',
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
			return Redirect::to('student.unpaid');
		}
	}

	/**
	 * 判断当前学生是否欠费
	 *
	 * @return boolean     欠费为TRUE，未欠费为FALSE
	 */
	protected function unpaid() {
		$sql  = 'SELECT xh FROM t_xk_xsqf WHERE xh = ?';
		$data = DB::getInstance()->getRow($sql, Session::read('username'));

		return strcasecmp($data['xh'], Session::read('username')) ? false : true;
	}

	/**
	 * 获取当前学生可选课程表
	 * @param  string $type 课程类型
	 * @return mixed       可选课程数据
	 */
	protected function index($type) {
		list($property, $platform) = array_pad(str_split($this->codes[$type]['code']), 2, '');

		if (in_array($property . $platform, array($this->codes[BASIC]['code'], $this->codes[REQUIRED]['code'], $this->codes[ELECTIVE]['code']))) {
			$grade      = Session::read('grade');
			$speciality = Session::read('spno');
		} else {
			$sql  = 'SELECT DISTINCT nj FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND zsjj = ?';
			$data = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), Session::read('season')));
			foreach ($data as $g) {
				$grade[] = $g['nj'];
			}

			$sql  = 'SELECT DISTINCT zy FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND zsjj = ?';
			$data = DB::getInstance()->searchRecord($sql, array(Session::read('year'), Session::read('term'), Session::read('season')));
			foreach ($data as $sp) {
				$speciality[] = $sp['zy'];
			}
		}

		if (isEmpty($platform)) {
			$platform = is_array($platform) ? $platform : array($platform);
			$data     = DB::getInstance()->getAll('SELECT dm FROM t_zd_pt');
			foreach ($data as $pt) {
				if (isEmpty($pt['dm']) || in_array($property . $pt['dm'], array_column($this->codes, 'code'))) {
					continue;
				}
				$platform[] = $pt['dm'];
			}
		}

		$param = "'" . implode("','", array(Session::read('season'), Session::read('username'), array_to_pg(Session::read('year')), array_to_pg(Session::read('term')), array_to_pg($platform), array_to_pg($property), array_to_pg($grade), array_to_pg($speciality))) . "'";
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

		return $this->view->display('course.index', array('courses' => $courses, 'title' => $this->codes[$type]['name']));
	}

	/**
	 * 检索课程
	 * @param  string $type 检索类型
	 * @return array          课程数组
	 */
	protected function search($type) {
		$courses = array();
		if (isPost()) {
			switch($type) {
				case OTHERS:
				$year = Session::read('year');
				$term = Session::read('term');
					$grade = '*';
					$speciality = '*';

					$data = DB::getInstance()->getAll('SELECT dm FROM t_zd_pt');
					foreach ($data as $pt) {
						if (!isEmpty($pt['dm'])) {
							$platform[] = $pt['dm'];
						}
					}

					$data = DB::getInstance()->getAll('SELECT dm FROM t_zd_xz');
					foreach ($data as $xz) {
						if(isset($platform) && (isEmpty($xz['dm']) || in_array(array_map(function($pt) { return $pt.$xz['dm']; }, $platform), array($this->codes[HUMANITY]['code'], $this->codes[NATURAL]['code'], $this->codes[ART]['code'], $this->codes[SPECIAL]['code'])))) {
							continue;
						}

						$property[] = $xz['dm'];
					}

					break;

				case RETAKE:
					$grade = '*';
					$speciality = '*';
					$platform = '*';
					$property = '*';

					$sql = 'SELECT year, term FROM v_xk_kxkcxx WHERE nd <> ? AND xq <> ? GROUP BY year, term';
					$data = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term')));
					foreach ($data as $d) {
						$year[] = $d['year'];
						$term[] = $d['term'];
					}
					break;

				default:
					break;
			}

			if (isset($grade) && isset($speciality) && isset($platform) && isset($property)) {
				$param = "'" . implode("','", array(Session::read('season'), Session::read('username'), array_to_pg(Session::read('year')), array_to_pg(Session::read('term')), array_to_pg($platform), array_to_pg($property), array_to_pg($grade), array_to_pg($speciality))) . "'";
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
	 * 获取当前学生非本年级本专业课程
	 * @return mixed 非本年级本专业课程数据包
	 */
	protected function notgs() {
		$sql    = 'SELECT DISTINCT nj FROM v_xk_kxkcxx WHERE nd = ? AND xq = ? AND zy = ? AND nj <> ? ORDER BY nj';
		$grades = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), Session::read('spno'), Session::read('grade')));

		$sql    = 'SELECT DISTINCT a.zy AS zyh, b.mc AS zy FROM v_xk_kxkcxx a INNER JOIN t_jx_zy b ON a.zy = b.zy WHERE a.nd = ? AND a.xq = ? AND a.zy <> ?';
		$majors = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), Session::read('spno')));

		return $this->view->display('course.notgs', array('grades' => $grades, 'majors' => $majors));
	}

	/**
	 * 获取当前学生可选重修课程表
	 * @return mixed 重修课程数据包
	 */
	protected function retake() {
		$title = '可重修课程';
		$param = "'" . implode("','", array(Session::read('username'))) . "'";
		$data  = DB::getInstance()->query('SELECT * FROM p_cxkcb_sel(' . $param . ')');

		$courses = array();
		foreach ($data as $course) {
			if (isEmpty($course['xqh'])) {
				$courses['unknown'][$course['kcxh']][] = $course;
			} else {
				$courses[$course['xqh']][$course['kcxh']][] = $course;
			}
		}
		krsort($courses);

		return $this->view->display('course.retake', array('courses' => $courses, 'title' => $title));
	}

	/**
	 * 选择课程
	 *
	 * @return boolean       选课成功为TRUE，不成功为FALSE
	 */
	protected function select() {
		if (isPost()) {
			$cno     = $_POST['course'];
			$checked = $_POST['checked'];

			if ('true' == $checked) {
				if ($this->full($cno)) {
					echo 'full';
					return 'full';
				}
				$param = "'" . implode("','", array(Session::read('username'), $cno)) . "'";

				$selected = DB::getInstance()->query('SELECT p_xzkc_save(' . $param . ')');
				if (isAjax()) {
					if ($selected) {
						Logger::write(array('xh' => Session::read('username'), 'kcxh' => $cno, 'czlx' => LOG_INSERT));
						echo 'success';
					} else {
						echo 'failed';
					}
				} else {
					return $selected;
				}
			} else {
				$param = "'" . implode("','", array(Session::read('username'), $cno)) . "'";

				$deleted = DB::getInstance()->query('SELECT p_scxk_del(' . $param . ')');
				if (isAjax()) {
					if ($deleted) {
						Logger::write(array('xh' => Session::read('username'), 'kcxh' => $cno, 'czlx' => LOG_DELETE));
						echo 'success';
					} else {
						echo 'failed';
					}
					echo $deleted ? 'success' : 'failed';
				} else {
					return $deleted;
				}
			}
		}
	}

	/**
	 * 选课时间冲突检测
	 * @param  string $course 课程序号
	 * @return mixed 冲突为冲突课程序号数组，否则为FALSE
	 */
	protected function check($course) {
		if (isPost()) {
			$collision = false;

			$sql      = 'SELECT kcxh, ksz, jsz, zc, ksj, jsj FROM t_pk_kb WHERE nd = ? AND xq = ? AND kcxh = ?';
			$currents = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), $course));

			$sql      = 'SELECT kcxh, ksz, jsz, zc, ksj, jsj FROM v_xk_xskcb WHERE xh = ? AND nd = ? AND xq = ?';
			$compares = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term')));

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

			return $collision;
		}
	}

	/**
	 * 判断是否选课人数已满
	 * @param  string $course 课程序号
	 * @return boolean         人数已满为TRUE，未满为FALSE
	 */
	protected function full($course) {
		$sql  = 'SELECT jhrs, rs FROM t_xk_tj WHERE kcxh = ?';
		$data = DB::getInstance()->getRow($sql, $course);

		return 0 < $data['jhrs'] && $data['jhrs'] < $data['rs'];
	}

	/**
	 * 选课申请
	 * @return NULL
	 */
	protected function apply() {
		if (isPost()) {
			$data['xh']   = Session::read('username');
			$data['xm']   = Session::read('name');
			$data['nd']   = Session::read('year');
			$data['xq']   = Session::read('term');
			$data['kcxh'] = $_POST['course'];
			$data['sj']   = date('Y-m-d H:i:s');
			$data['cx']   = ENABLE;

			$sql          = 'SELECT kch, kkxy FROM v_xk_kxkcxx WHERE kcxh = ? AND nd = ? AND xq = ?';
			$course       = DB::getInstance()->getRow($sql, array($_POST['course'], Session::read('year'), Session::read('term')));
			$data['kch']  = $course['kch'];
			$data['kkxy'] = $course['kkxy'];
			DB::getInstance()->insertRecord('t_xk_xksq', $data);

			Logger::write(array('xh' => Session::read('username'), 'kcxh' => $data['kcxh'], 'czlx' => LOG_APPLY));

			echo 'success';
		}
	}

}
