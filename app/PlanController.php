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
			'ZB' => 0,
			'TW' => 0,
			'TI' => 0,
			'TY' => 0,
			'TQ' => 0,
			'KX' => 0,
			'JX' => 0,
			'ZX' => 0,
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

	/**
	 * 获取当前学生选课情况
	 * @return void
	 */
	protected function selected() {
		$credits = array();

		// 获取毕业应修学分
		$requirements = $this->model->getGraduation($this->session->get('grade'), $this->session->get('spno'), $this->session->get('season'), $this->session->get('plan'));
		if (!empty($requirements)) {
			foreach ($requirements as $requirement) {
				$credits[$requirement['pt'] . $requirement['xz']]['platform']    = $requirement['pt'];
				$credits[$requirement['pt'] . $requirement['xz']]['property']    = $requirement['xz'];
				$credits[$requirement['pt'] . $requirement['xz']]['requirement'] = $requirement['xf'];
			}
		}

		// 获取本次选修学分
		$selectedCredits = $this->model->getSelectedCredits($this->session->get('year'), $this->session->get('term'), $this->session->get('username'));
		if (!empty($selectedCredits)) {
			foreach ($selectedCredits as $selected) {
				$credits[$selected['pt'] . $selected['xz']]['platform'] = $selected['pt'];
				$credits[$selected['pt'] . $selected['xz']]['property'] = $selected['xz'];
				$credits[$selected['pt'] . $selected['xz']]['selected'] = $selected['xf'];
			}
		}

		// 获取正在修读学分
		$selectingCredits = $this->model->getStudyingCredits($this->session->get('year'), $this->session->get('term'), $this->session->get('username'));
		if (!empty($selectingCredits)) {
			foreach ($selectingCredits as $selecting) {
				$credits[$selecting['pt'] . $selecting['xz']]['platform']  = $selecting['pt'];
				$credits[$selecting['pt'] . $selecting['xz']]['property']  = $selecting['xz'];
				$credits[$selecting['pt'] . $selecting['xz']]['selecting'] = $selecting['xf'];
			}
		}

		// 获取已修读学分
		$studiedCredits = $this->model->getStudiedCredits($this->session->get('username'));
		if (!empty($studiedCredits)) {
			foreach ($studiedCredits as $studied) {
				$credits[$studied['pt'] . $studied['kcxz']]['platform'] = $studied['pt'];
				$credits[$studied['pt'] . $studied['kcxz']]['property'] = $studied['kcxz'];
				$credits[$studied['pt'] . $studied['kcxz']]['studied']  = $studied['xf'];
			}
		}

		return $this->view->display('plan.selected', array('credits' => $credits));

	}

	/**
	 * 获取当前学生对应课程平台、课程性质学生详细情况
	 * @param  string $platform 课程平台
	 * @param  string $property 课程性质
	 * @return void
	 */
	protected function detail($platform, $property) {
		$data        = $this->model->getGraduation($this->session->get('grade'), $this->session->get('spno'), $this->session->get('season'), $this->session->get('plan'), $platform, $property);
		$requirement = empty($data) ? 0 : $data[0]['xf'];

		$data    = $this->model->getStudiedCredits($this->session->get('username'), $platform, $property);
		$studied = empty($data) ? 0 : $data[0]['xf'];

		$scores = $this->model->getReport($this->session->get('username'), $platform, $property);

		$data     = $this->model->getStudyingCredits($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $platform, $property);
		$studying = empty($data) ? 0 : $data[0]['xf'];

		$studyingCourses = $this->model->getStudyingReport($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $platform, $property);

		$unstudiedCourses = $this->model->getUnstudiedCourses($this->session->get('username'), $this->session->get('grade'), $this->session->get('spno'), $this->session->get('season'));
		$electiveCourses  = $this->model->getElectiveCourses($this->session->get('grade'), $this->session->get('spno'), $this->session->get('season'));
		return $this->view->display('plan.detail', array('platform' => $platform, 'property' => $property, 'requirement' => $requirement, 'studied' => $studied, 'scores' => $scores, 'studying' => $studying, 'studyingCourses' => $studyingCourses, 'unstudiedCourses' => $unstudiedCourses, 'electiveCourses' => $electiveCourses));
	}

}
