<?php

/**
 * 教师课程表类
 */
class CurriculumController extends TeacherAdminController {

	/**
	 * 列出当前教师课程表
	 * @return void
	 */
	protected function listing() {
		$courses = $this->model->listCourses($this->session->get('username'));

		$coursesByTerm = array();
		foreach ($courses as $course) {
			$coursesByTerm[$course['nd'] . $course['xq']][$course['kcxh']][] = $course;
		}
		krsort($coursesByTerm);

		return $this->view->display('curriculum.listing', array('courses' => $coursesByTerm));
	}

	/**
	 * 列出当前教师课程表
	 * @return array 教师课程表
	 */
	protected function timetable() {
		$courses = $this->model->listCourses($this->session->get('username'));
		$years   = array_values(array_unique(array_column($courses, 'nd')));
		$terms   = array_values(array_unique(array_column($courses, 'xq')));

		foreach ($years as $year) {
			foreach ($terms as $term) {
				$coursesByClass[$year . $term] = array_fill(1, 12, array_fill(1, 7, '&nbsp;'));
			}
		}

		foreach ($courses as $course) {
			$begClass = $course['ksj'];
			$endClass = $course['jsj'];
			$week     = $course['zc'];

			if ('&nbsp;' == $coursesByClass[$course['nd'] . $course['xq']][$begClass][$week]) {
				$coursesByClass[$course['nd'] . $course['xq']][$begClass][$week] = array();
			}
			$coursesByClass[$course['nd'] . $course['xq']][$begClass][$week][] = array(
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
				$coursesByClass[$course['nd'] . $course['xq']][$i][$week] = null;
			}
		}
		krsort($coursesByClass);

		return $this->view->display('curriculum.timetable', array('courses' => $coursesByClass));
	}

}
