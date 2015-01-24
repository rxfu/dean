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
		$data = DB::getInstance()->searchRecord('v_xk_kskcb', array('xh'=>Session::read('username'), 'nd' => Session::read('year'), 'xq' => Session::read('term')))
		return $this->view->display('schedule.index', array('courses' => $data));
	}

	/**
	 * 根据年度、学期列出当前学生的课程表
	 *
	 * @param string  $nd 年度
	 * @param string  $xq 学期
	 * @return array     学生课程表
	 */
	protected function term($year, $term) {
		$data = DB::getInstance()->searchRecord('v_xk_xskcb', array('xh' => Session::read('username'), 'nd' => $year, 'xq' => $term));

		return $this->view->display('schedule.term', array('courses' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 列出当前年度、学期专业课程表
	 * @return void
	 */
	protected function speciality() {
		$sql  = 'SELECT DISTINCT kch, kcmc, kcywmc, xs, xf FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND nj = ? AND zyh = ?';
		$data = DB::getInstance()->searchRecord($sql, array(Session::read('year'), Session::read('term'), Session::read('grade'), ession::read('spno')));

		return $this->view->display('schedule.speciality', array('courses' => $data, 'year' => $year, 'term' => $term));
	}
}