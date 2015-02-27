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
		$data = $this->db->searchRecord('v_xk_jxjh', array('zy' => $this->session->get('spno'), 'nj' => $this->session->get('grade'), 'zsjj' => $this->session->get('season')));

		return $this->view->display('plan.plan', array('plans' => $data, 'college' => $this->session->get('college'), 'grade' => $this->session->get('grade'), 'speciality' => $this->session->get('speciality')));
	}

	/**
	 * 列出课程详细信息
	 *
	 * @return array       课程详细信息列表
	 */
	protected function course() {
		$data = $this->db->searchRecord('t_jx_kc_xx');

		return $this->view->display('plan.course', array('courses' => $data));
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
		$requirements = $this->db->searchRecord('t_jx_byyq', array('zy' => $this->session->get('spno'), 'nj' => $this->session->get('grade'), 'zsjj' => $this->session->get('season'), 'byfa' => $this->session->get('plan')));

		if (is_array($requirements)) {
			foreach ($requirements as $requirement) {
				$data[$requirement['pt'] . $requirement['xz']] = $requirement['xf'];
			}
		}

		return $this->view->display('plan.graduation', array('require' => $data));
	}

}