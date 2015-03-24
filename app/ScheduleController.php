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
		$courses = $this->model->getTimetable($this->session->get('year'), $this->session->get('term'), $this->session->get('username'));
		foreach ($courses as $course) {
			$coursesByNumber[$course['kcxh']][] = $course;
		}
		ksort($coursesByNumber);

		return $this->view->display('schedule.current', array('courses' => $coursesByNumber));
	}

	/**
	 * 列出当前年度、学期专业课程表
	 * @return void
	 */
	protected function speciality() {
		$courses = $this->model->getSpecialCourses($this->session->get('year'), $this->session->get('term'), $this->session->get('grade'), $this->session->get('spno'));

		return $this->view->display('schedule.speciality', array('courses' => $courses));
	}

	/**
	 * 列出当前学生课程表
	 * @return array 学生课程表
	 */
	protected function timetable() {
		$courses = $this->model->getTimetable($this->session->get('year'), $this->session->get('term'), $this->session->get('username'));

		$coursesByClass = array_fill(1, 12, array_fill(1, 7, '&nbsp;'));
		foreach ($courses as $course) {
			$begClass = $course['ksj'];
			$endClass = $course['jsj'];
			$week     = $course['zc'];

			if ('&nbsp;' == $coursesByClass[$begClass][$week]) {
				$coursesByClass[$begClass][$week] = array();
			}
			$coursesByClass[$begClass][$week][] = array(
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

			for ($i = $begClass + 1; $i <= $endClass; ++$i) {
				$coursesByClass[$i][$week] = null;
			}
		}
		
		return $this->view->display('schedule.timetable', array('courses' => $coursesByClass));
	}
}