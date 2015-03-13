<?php

/**
 * 教学计划类
 */
class PlanController extends StudentAdminController {

	/**
	 * 列出当前学生的教学计划
	 *
	 * @return array         教学计划信息
	 */
	protected function plan() {
		$plan = $this->model->getPlan($this->session->get('grade'), $this->session->get('spno'), $this->session->get('season'));
		$plan = is_array($plan) ? $plan : array();

		return $this->view->display('plan.plan', array('plans' => $plan));
	}

	/**
	 * 列出课程详细信息
	 *
	 * @return array       课程详细信息列表
	 */
	protected function course() {
		$courses = $this->model->getCourses();
		$courses = is_array($courses) ? $courses : array();

		return $this->view->display('plan.course', array('courses' => $courses));
	}

	/**
	 * 列出当前学生的毕业要求
	 *
	 * @return array         毕业要求的学分数组
	 */
	protected function graduation() {
		$data = array(
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

		if (is_array($requirements)) {
			foreach ($requirements as $requirement) {
				$data[$requirement['pt'] . $requirement['xz']] = $requirement['xf'];
			}
		} else {
			$data = array();
		}

		return $this->view->display('plan.graduation', array('require' => $data));
	}

}