<?php

/**
 * 成绩类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
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
		if ($scores) {
			foreach ($scores as $score) {
				$scoresByGrades[$score['cjfs']]['ratios']    = $this->model->getRatio($score['cjfs']);
				$scoresByGrades[$score['cjfs']]['courses'][] = $score;
			}
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
		if ($scores) {
			foreach ($scores as $score) {
				$scoresByType[$score['c_kslx']][] = $score;
			}
		}

		return $this->view->display('report.exam', array('scores' => $scoresByType));
	}

	/**
	 * 课程转换申请
	 * @return NULL
	 */
	protected function transfer() {
		$plan      = new PlanModel();
		$electives = $plan->getElectives();
		$courses   = $plan->getCoursesByStudent($this->session->get('spno'), $this->session->get('grade'), $this->session->get('season'));

		$report   = new ScoreModel();
		$statuses = $report->getStatuses();

		if (isPost()) {
			$_POST = sanitize($_POST);

			$this->model->applyCreditTransfer(
				$this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('username'),
				$this->session->get('name'),
				$this->session->get('spno'),
				$this->session->get('grade'),
				$this->session->get('season'),
				$_POST['lcno'],
				$_POST['lcname'],
				$_POST['lplatform'],
				$_POST['lproperty'],
				isset($_POST['lelective']) ? $_POST['lelective'] : '',
				$_POST['method'],
				$_POST['lcredit'],
				$_POST['lscore'],
				$_POST['lgpa'],
				$_POST['status'],
				$_POST['cno'],
				$_POST['reason']);

			return redirect('report.process');
		}

		return $this->view->display('report.transfer', array('electives' => $electives, 'statuses' => $statuses, 'courses' => $courses));
	}

	/**
	 * 撤销课程转换申请
	 * @return void
	 */
	protected function revoke() {
		if (isPost()) {
			$_POST = sanitize($_POST);
			$lcno  = $_POST['lcno'];
			$cno   = $_POST['cno'];

			$this->model->revokeCreditTransfer($this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('username'),
				$lcno,
				$cno);
		}

		return redirect('report.process');
	}

	/**
	 * 列出当前学生的课程转换申请列表
	 * @return array 课程转换申请列表
	 */
	protected function process() {
		$courses = $this->model->getApplications($this->session->get('username'));

		return $this->view->display('report.process', array('courses' => $courses));
	}

}
