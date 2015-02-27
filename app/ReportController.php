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
	protected function report() {
		$data = DB::getInstance()->searchRecord('v_cj_xscj', array('xh' => $this->session->get('username')));

		return $this->view->display('report.report', array('scores' => $data, 'name' => $this->session->get('name')));
	}

	/**
	 * 根据课程号列出当前学生过程成绩清单
	 *
	 * @param string  $cno 课程号
	 * @return array       学生成绩
	 */
	protected function detail($cno) {
		$sql  = 'SELECT * FROM v_cj_xsgccj WHERE kch = ? AND xh = ? AND tjzt = ? ORDER BY nd, xq';
		$data = DB::getInstance()->getAll($sql, array($cno, $this->session->get('username'), DEAN_CONFIRMED));

		$ratios = array();
		$scores = array();
		foreach ($data as $score) {
			$scores[$score['cjfs']]['ratios']    = $this->ratio($score['cjfs']);
			$scores[$score['cjfs']]['courses'][] = $score;
		}

		return $this->view->display('report.detail', array('scores' => $scores, 'cname' => $data[0]['kcmc'], 'name' => $this->session->get('name')));
	}

	/**
	 * 列出当前学生未确认成绩表
	 * @return void
	 */
	protected function unconfirmed() {
		$sql  = 'SELECT * FROM v_cj_xsgccj WHERE nd = ? AND xq = ? AND xh = ? AND tjzt = ? ORDER BY kcxh';
		$data = DB::getInstance()->getAll($sql, array($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), COLLEGE_CONFIRMED));

		$ratios = array();
		$scores = array();
		foreach ($data as $score) {
			$scores[$score['cjfs']]['ratios']    = $this->ratio($score['cjfs']);
			$scores[$score['cjfs']]['courses'][] = $score;
		}
		return $this->view->display('report.unconfirmed', array('scores' => $scores, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
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
