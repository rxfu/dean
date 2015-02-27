<?php

/**
 * 课程表类
 */
class ScheduleController extends StudentAdminController {

	/**
	 * 列出当前学生当前年度、学期选课课程表
	 * @return void
	 */
	protected function current() {
		$data = DB::getInstance()->searchRecord('v_xk_xskcb', array('xh' => $this->session->get('username'), 'nd' => $this->session->get('year'), 'xq' => $this->session->get('term')));
		
		$courses = array();
		foreach ($data as $course) {
			$courses[$course['kcxh']][] = $course;
		}

		return $this->view->display('schedule.current', array('courses' => $courses, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

	/**
	 * 列出当前年度、学期专业课程表
	 * @return void
	 */
	protected function speciality() {
		$sql  = 'SELECT DISTINCT kch, kcmc, kcywmc, pt, xz, xs, xf FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND nj = ? AND zyh = ?';
		$data = DB::getInstance()->getAll($sql, array($this->session->get('year'), $this->session->get('term'), $this->session->get('grade'), $this->session->get('spno')));

		return $this->view->display('schedule.speciality', array('courses' => $data, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

	/**
	 * 列出当前学生课程表
	 * @return array 学生课程表
	 */
	protected function timetable() {
		$sql  = 'SELECT * FROM v_xk_xskcb WHERE nd = ? AND xq = ? AND xh = ? ORDER BY ksj, zc';
		$data = DB::getInstance()->getAll($sql, array($this->session->get('year'), $this->session->get('term'), $this->session->get('username')));

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
		
		return $this->view->display('schedule.timetable', array('courses' => $courses, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}
}