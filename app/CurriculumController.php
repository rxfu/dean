<?php

/**
 * 教师课程表类
 */
class CurriculumController extends TeacherAdminController {

	/**
	 * 按年度、学期列出当前教师课程表
	 * @return void
	 */
	protected function term($year, $term) {
		$sql  = 'SELECT * FROM v_pk_jskcb WHERE nd = ? AND xq = ? AND jsgh = ? ORDER BY kcxh, ksz, zc, ksj';
		$data = $this->db->getAll($sql, array($year, $term, $this->session->get('username')));

		$courses = array();
		foreach ($data as $course) {
			$courses[$course['kcxh']][] = $course;
		}

		return $this->view->display('curriculum.term', array('courses' => $courses, 'year' => $year, 'term' => $term));
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

		return $this->view->display('curriculum.timetable', array('courses' => $courses));
	}

}
