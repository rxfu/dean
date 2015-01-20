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
		$id   = Session::read('username');
		$data = DB::getInstance()->searchRecord('v_cj_xscj', array('xh' => $id));

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
		$data = DB::getInstance()->searchRecord('v_cj_xscj', array('xh' => Session::read('username'), 'nd' => $year, 'xq' => $term));

		return $this->view->display('report.term', array('scores' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 教师录入成绩
	 * @param  string $cno 课程序号
	 * @return array          学生成绩
	 */
	protected function input($cno) {
		$electTerm = Configuration::get('CJ_WEBSJ');
		$term      = parseTerm($electTerm);
		$sql       = 'SELECT * FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		$course    = DB::getInstance()->getRow($sql, array($term['year'], $term['term'], $cno));

		$sql  = 'SELECT * FROM t_cj_lscj WHERE nd = ? AND xq = ? AND kcxh = ?';
		$data = DB::getInstance()->getAll($sql, array($term['year'], $term['term'], $cno));

		return $this->view->display('report.input', array('course' => $course, 'scores' => $data));
	}

	/**
	 * 按年度按学期列出成绩单
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return array       成绩单列表
	 */
	protected function summary($year, $term) {
		$sql  = 'SELECT kcxh, kcmc FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND jsgh = ?';
		$data = DB::getInstance()->getAll($sql, array($year, $term, Session::read('username')));

		return $this->view->display('report.summary', array('courses' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 列出课程成绩
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno 课程序号
	 * @return array         成绩列表
	 */
	protected function score($year, $term, $cno) {
		$sql    = 'SELECT kch FROM t_pk_jxrw WHERE nd = ? AND xq = ? AND kcxh = ? AND jsgh = ?';
		$course = DB::getInstance()->getRow($sql, array($year, $term, $cno, Session::read('username')));

		$data = DB::getInstance()->getAll('v_cj_xscj', array('nd' => $year, 'xq' => $term, 'kch' => $course['kch']));
		return $this->view->display('report.score', array('scores' => $data));
	}
}