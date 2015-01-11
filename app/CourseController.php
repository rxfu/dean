<?php

/**
 * 课程类
 */
class CourseController extends Controller {

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
	 * @param  string $type 课程性质
	 * @return mixed       可选课程数据
	 */
	protected function index($type) {
		switch ($type) {
			case 'pub':
				$title    = '公共课程';
				$platform = 'T';
				$property = 'B';
				break;

			case 'req':
				$title    = '必修课程';
				$property = 'B';

				$data = DB::getInstance()->getAll('SELECT dm FROM t_zd_pt');
				foreach ($data as $pt) {
					if ('T' !== $pt['dm']) {
						$platform[] = $pt['dm'];
					}
				}
				break;

			case 'sel':
				$title    = '选修课程';
				$property = 'X';

				$data = DB::getInstance()->getAll('SELECT dm FROM t_zd_pt');
				foreach ($data as $pt) {
					if ('T' !== $pt['dm'] || 'W' !== $pt['dm'] || 'I' !== $pt['dm'] || 'Y' !== $pt['dm'] || 'Q' !== $pt['dm']) {
						$platform[] = $pt['dm'];
					}
				}
				break;

			case 'hs':
				$title    = '人文社科通识素质课程';
				$property = 'X';
				$platform = 'W';
				break;

			case 'ns':
				$title    = '自然科学通识素质课程';
				$property = 'X';
				$platform = 'I';
				break;

			case 'as':
				$title    = '艺术体育通识素质课程';
				$property = 'X';
				$platform = 'Y';
				break;

			case 'os':
				$title    = '其他专项通识素质课程';
				$property = 'X';
				$platform = 'Q';
				break;

			case 'ret':
				$title = '重修课程';
				break;

			default:
				$title = '可选课程';
				$data  = DB::getInstance()->getAll('SELECT dm FROM t_zd_xz');
				foreach ($data as $xz) {
					$property[] = $xz['dm'];
				}
				$data = DB::getInstance()->getAll('SELECT dm FROM t_zd_pt');
				foreach ($data as $pt) {
					$platform[] = $pt['dm'];
				}
				break;
		}
		$param = "'" . implode("','", array(Session::read('username'), array_to_pg($platform), array_to_pg($property))) . "'";
		$data  = DB::getInstance()->query('SELECT * FROM p_kxkcb_sel(' . $param . ')');

		$courses = array();
		foreach ($data as $course) {
			if (isEmpty($course['xqh'])) {
				$courses['unknown'][] = $course;
			} else {
				$courses[$course['xqh']][] = $course;
			}
		}
		krsort($courses);
		return $this->view->render('course.index', array('courses' => $courses, 'title' => $title));
	}

	/**
	 * 获取当前学生可选重修课程表
	 * @return mixed 重修课程数据包
	 */
	protected function retake() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.retake', array('courses' => $data));
	}

	/**
	 * 选择课程
	 *
	 * @return boolean       选课成功为TRUE，不成功为FALSE
	 */
	protected function select() {
		if (isPost()) {
			$cno  = $_POST['course'];

			$selected = DB::getInstance()->query("SELECT p_xzkc_save('" . Session::read('username') . "', '" . $platform . "', '" . $property . "'");
			if ($selected) {
				Session::flash('success', '选课成功');
			} else {
				Session::flash('danger', '选课失败');
			}
		}
	}

	/**
	 * 取消选课
	 * @return boolean 取消成功为TRUE，取消失败为FALSE
	 */
	protected function drop() {
		if (isPost()) {
			$cno = $_POST['course'];
			$param = "'" . implode("',", array(Session::read('username'), $cno)) . "'";

			$deleted = DB::getInstance()->query('SELECT p_scxk_del(' . $param . ')');
			if ($deleted) {
				Session::flash('success', '删除选课成功');
			} else {
				Session::flash('danger', '删除选课失败');
			}
		}
	}

	/**
	 * 选课时间冲突检测
	 * @return mixed 冲突为冲突课程序号数足，否则为FALSE
	 */
	protected function check() {
		if (isPost()) {
			$cno = $_POST['course'];
			$collision = false;

			$sql = 'SELECT kcxh, ksz, jsz, zc, ksj, jsj FROM t_pk_kb WHERE nd = ? AND xq = ? AND kcxh = ?';
			$currents = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), $cno));

			$sql = 'SELECT kcxh, ksz, jsz, zc, ksj, jsj FROM v_xk_xskcb WHERE xh = ? AND nd = ? AND xq = ?';
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
	 * 选课申请
	 * @return NULL
	 */
	protected function apply() {
		if (isPost()) {
			$data['xh']   = Session::read('username');
			$data['xm']   = Session::read('name');
			$data['nd']   = Session::read('year');
			$data['xq']   = Session::read('term');
			$data['kcxh'] = $_POST['cno'];
			DB::getInstance()->insertRecord('t_xk_xksq', $data);

			Logger::write(array('xh' => Session::read('username'), 'kcxh' => $data['kcxh'], 'czlx' => LOG_APPLY));
		}
	}

}
