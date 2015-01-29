<?php

/**
 * 课程表类
 */
class ScheduleController extends Controller {

	/**
	 * 列出当前学生当前年度、学期选课课程表
	 * @return void
	 */
	protected function index() {
		$data = DB::getInstance()->searchRecord('v_xk_xskcb', array('xh' => Session::read('username'), 'nd' => Session::read('year'), 'xq' => Session::read('term')));
		
		$courses = array();
		foreach ($data as $course) {
			$courses[$course['kcxh']][] = $course;
		}

		return $this->view->display('schedule.index', array('courses' => $courses));
	}

	/**
	 * 列出当前年度、学期专业课程表
	 * @return void
	 */
	protected function speciality() {
		$sql  = 'SELECT DISTINCT kch, kcmc, kcywmc, pt, xz, xs, xf FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND nj = ? AND zyh = ?';
		$data = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), Session::read('grade'), Session::read('spno')));

		return $this->view->display('schedule.speciality', array('courses' => $data));
	}

	/**
	 * 列出当前学生课程表
	 * @return array 学生课程表
	 */
	protected function timetable() {
		$sql  = 'SELECT * FROM v_xk_xskcb WHERE nd = ? AND xq = ? AND xh = ? ORDER BY ksj, zc';
		$data = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), Session::read('username')));

		$courses = array_fill(1, 12, array_fill(1, 7, '&nbsp;'));
		foreach ($data as $course) {
			$begClass = $course['ksj'];
			$endClass = $course['jsj'];
			$week     = $course['zc'];

			if ('&nbsp;' == $courses[$begClass][$week]) {
				$courses[$begClass][$week] = array();
			}
			$courses[$begClass][$week][] = array(
				'kcxh'   => $course['kcxh'],
				'kcmc'   => $course['kcmc'],
				'kcywmc' => $course['kcywmc'],
				'ksz'    => $course['ksz'],
				'jsz'    => $course['jsz'],
				'ksj'    => $course['ksj'],
				'jsj'    => $course['jsj'],
				'zc'     => $course['zc'],
				'xqh'    => $course['xqh'],
				'jsmc'   => $course['jsmc'],
				'jsxm'   => $course['jsxm'],
			);

			for ($i = $begClass + 1; $i < $endClass - $begClass; ++$i) {
				$courses[$i][$week] = null;
			}
		}
		return $this->view->display('schedule.timetable', array('courses' => $courses));
	}
}