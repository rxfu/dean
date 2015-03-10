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
		$scores = $this->model->getReport($this->session->get('username'));
		return $this->view->display('report.report', array('scores' => $scores));
	}

	/**
	 * 根据课程号列出当前学生过程成绩清单
	 *
	 * @param string  $cno 课程号
	 * @return array       学生成绩
	 */
	protected function detail($cno) {
		$scores         = $this->model->getDetail($this->session->get('username'), $cno);
		$cname          = is_array($scores) ? $scores[0]['kcmc'] : '';
		$scoresByGrades = array();
		foreach ($scores as $score) {
			$scoresByGrades[$score['cjfs']]['ratios']    = $this->model->getRatio($score['cjfs']);
			$scoresByGrades[$score['cjfs']]['courses'][] = $score;
		}

		return $this->view->display('report.detail', array('scores' => $scoresByGrades, 'cname' => $cname));
	}

	/**
	 * 列出当前学生未确认成绩表
	 * @return void
	 */
	protected function unconfirmed() {
		$scores         = $this->model->getUnconfirmed($this->session->get('username'));
		$scoresByGrades = array();
		foreach ($scores as $score) {
			$scoresByGrades[$score['cjfs']]['ratios']    = $this->model->getRatio($score['cjfs']);
			$scoresByGrades[$score['cjfs']]['courses'][] = $score;
		}

		return $this->view->display('report.unconfirmed', array('scores' => $scoresByGrades));
	}

	/**
	 * 列出当前学生国家考试成绩单
	 * @return void
	 */
	protected function exam() {
		$scores       = $this->model->getExamReport($this->session->get('username'));
		$scoresByType = array();
		foreach ($scores as $score) {
			$scoresByType[$score['c_kslx']][] = $score;
		}

		return $this->view->display('report.exam', array('scores' => $scoresByType));
	}

}
