<?php

/**
 * 成绩类
 */
class ReportController extends Controller {

	/**
	 * 列出当前学生所有成绩
	 *
	 * @return array     学生成绩
	 */
	protected function index() {
		$id = Session::read('username');
		if (is_numeric($id) && isset($id{11}) && !isset($id{12})) {
			$data = DB::getInstance()->searchRecord('v_xk_xscj', array('xh' => $id));
		}

		return $this->view->display('report.index', array('scores' => $data));
	}

	/**
	 * 根据年度、学期列出当前学生成绩
	 *
	 * @param string  $year 年度
	 * @param string  $term 学期
	 * @return array       学生成绩
	 */
	protected function term($year, $term) {
		$data = DB::getInstance()->searchRecord('v_xk_xscj', array('xh' => Session::read('username'), 'nd' => $year, 'xq' => $term));

		return $this->view->display('report.term', array('scores' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 教师录入成绩
	 * @param  string $course 课程序号
	 * @return array          学生成绩
	 */
	protected function input($course) {
		$electTerm = Configuration::get('XK_SJ');
		$term      = parseTerm($electTerm);
		$data      = DB::getInstance()->searchRecord('v_pk_kczyxx', array('nd' => $term['year'], 'xq' => $term['term'], 'kcxh' => $course));

		return $this->view->display('report.input', array('course' => $data));
	}

	/**
	 * 按年度按学期列出成绩单
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return array       成绩单列表
	 */
	protected function summary($year, $term) {
		$sql = 'SELECT kcxh, kcmc FROM v_pk_kczyxx WHERE nd = ? AND xq = ?';
		$data = DB::getInstance()->getAll($sql, array($year, $term));
		
		return $this->view->display('report.summary', array('courses' => $data));
	}

	/**
	 * 列出课程成绩
	 * @param  string $course 课程序号
	 * @return array         成绩列表
	 */
	protected function score($course) {
		return $this->view->display('report.score', array('course' => $course));
	}
}