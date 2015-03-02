<?php

/**
 * 教师课程表类
 */
class CurriculumController extends TeacherAdminController {

	/**
	 * 列出当前教师当前年度、学期课程表
	 * @return void
	 */
	protected function current() {
		$sql  = 'SELECT * FROM v_pk_jskcb WHERE nd = ? AND xq = ? AND jsgh = ? ORDER BY kcxh, ksz, zc, ksj';
		$data = $this->db->getAll($sql, array($this->session->get('year'), $this->session->get('term'), $this->session->get('username')));

		$courses = array();
		foreach ($data as $course) {
			$courses[$course['kcxh']][] = $course;
		}

		return $this->view->display('curriculum.current', array('courses' => $courses, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

	/**
	 * 列出当前教师课程表
	 * @return array 教师课程表
	 */
	protected function timetable() {
		$sql  = 'SELECT * FROM v_pk_jskcb WHERE nd = ? AND xq = ? AND jsgh = ? ORDER BY ksj, zc';
		$data = $this->db->getAll($sql, array($this->session->get('year'), $this->session->get('term'), $this->session->get('username')));

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
			);

			for ($i = $begClass + 1; $i < $endClass - $begClass; ++$i) {
				$courses[$i][$week] = null;
			}
		}

		return $this->view->display('curriculum.timetable', array('courses' => $courses, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

}
