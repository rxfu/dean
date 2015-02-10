<?php

/**
 * 成绩类
 */
class ReportController extends StudentAdminController {

	/**
	 * 列出当前学生所有成绩
	 *
	 * @return array     学生成绩
	 */
	protected function index() {
		$data = DB::getInstance()->searchRecord('v_cj_xscj', array('xh' => Session::get('username')));

		return $this->view->display('report.index', array('scores' => $data));
	}

	/**
	 * 根据课程号列出当前学生过程成绩清单
	 *
	 * @param string  $cno 课程号
	 * @return array       学生成绩
	 */
	protected function detail($cno) {
		$data = DB::getInstance()->searchRecord('v_cj_xsgccj', array('xh' => Session::get('username'), 'nd' => $year, 'xq' => $term));

		return $this->view->display('report.term', array('scores' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 列出当前学生未确认成绩表
	 * @return void
	 */
	protected function unconfirmed() {
		$sql  = 'SELECT * FROM v_cj_xsgccj WHERE nd = ? AND xq = ? AND xh = ? AND tjzt = ?ORDER BY kcxh';
		$data = DB::getInstance()->getAll($sql, array(Session::get('year'), Session::get('term'), Session::get('username'), COLLEGE_CONFIRMED));

		$ratios = array();
		$scores = array();
		foreach ($data as $score) {
			$scores[$score['cjfs']]['ratios']    = $this->ratio($score['cjfs']);
			$scores[$score['cjfs']]['courses'][] = $score;
		}
		return $this->view->display('report.unconfirmed', array('scores' => $scores));
	}

	/**
	 * 获取成绩方式对应的组合
	 * @param  string $grade 成绩方式代码
	 * @return array      成绩方式组合，没有返回FALSE
	 */
	protected function ratio($grade) {
		$modes = DB::getInstance()->searchRecord('t_jx_cjfs', array('fs' => $grade));
		if (is_array($modes)) {
			$ratios = array();
			foreach ($modes as $mode) {
				$ratios['name']              = $mode['khmc'];
				$ratios['mode'][$mode['id']] = array('idm' => $mode['idm'], 'bl' => $mode['bl'] / $mode['mf']);
			}

			return $ratios;
		}

		return false;
	}

}
