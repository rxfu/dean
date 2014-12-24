<?php

/**
 * 课程表类
 */
class ScheduleController extends Controller {

	/**
	 * 根据年度、学期列出当前学生的课程表
	 *
	 * @param string  $nd 年度
	 * @param string  $xq 学期
	 * @return array     学生课程表
	 */
	public function term($year, $term) {
		$data = DB::getInstance()->searchRecord('v_xk_xskcb', array('xh' => Session::read('username'), 'nd' => $year, 'xq' => $term));

		return $this->view->render('schedule.term', array('courses' => $data, 'year' => $year, 'term' => $term));
	}
}