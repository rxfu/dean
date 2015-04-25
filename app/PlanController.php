<?php

/**
 * 教学计划类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class PlanController extends StudentAdminController {

	/**
	 * 列出当前学生的教学计划
	 *
	 * @return array         教学计划信息
	 */
	protected function plan() {
		$plan = $this->model->getPlan($this->session->get('grade'), $this->session->get('spno'), $this->session->get('season'));

		return $this->view->display('plan.plan', array('plans' => $plan));
	}

	/**
	 * 列出课程详细信息
	 *
	 * @return array       课程详细信息列表
	 */
	protected function course() {
		$courses = $this->model->getCourses();

		return $this->view->display('plan.course', array('courses' => $courses));
	}

	/**
	 * 列出当前学生的毕业要求
	 *
	 * @return array         毕业要求的学分数组
	 */
	protected function graduation() {
		$studied = $selected = $require = array(
			'TB' => 0,
			'KB' => 0,
			'JB' => 0,
			'SB' => 0,
			'TW' => 0,
			'TI' => 0,
			'TY' => 0,
			'TQ' => 0,
			'KX' => 0,
			'JX' => 0,
		);

		$requirements = $this->model->getGraduation($this->session->get('grade'), $this->session->get('spno'), $this->session->get('season'), $this->session->get('plan'));
		if (!empty($requirements)) {
			foreach ($requirements as $requirement) {
				$require[$requirement['pt'] . $requirement['xz']] = $requirement['xf'];
			}
		}

		$selectedCredits = $this->model->getSelectedCredits($this->session->get('year'), $this->session->get('term'), $this->session->get('username'));
		if (!empty($selectedCredits)) {
			foreach ($selectedCredits as $credit) {
				$selected[$credit['pt'] . $credit['xz']] = $credit['xf'];
			}
		}

		$studiedCredits = $this->model->getStudiedCredits($this->session->get('username'));
		if (!empty($studiedCredits)) {
			foreach ($studiedCredits as $credit) {
				$studied[$credit['pt'] . $credit['kcxz']] = $credit['xf'];
			}
		}

		return $this->view->display('plan.graduation', array('require' => $require, 'selected' => $selected, 'studied' => $studied));
	}

}