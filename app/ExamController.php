<?php

/**
 * 考试控制类
 */
class ExamController extends StudentAdminController {

	/**
	 * 继承自基类before方法
	 * @return NULL
	 */
	protected function before() {
		$student = new StudentModel();

		if (!$student->isUploadedPortrait($this->session->get('id'))) {
			return redirect('student.upload');
		}

		parent::before();
	}

	/**
	 * 学生考试报名
	 * @param  string $type 考试类型
	 * @return void
	 */
	protected function register($type) {
		$exam = $this->model->getExamInfo($type);

		if ($this->model->isRegistered($this->session->get('username'), $type, $exam['sj'])) {
			$this->session->put('error', $exam['ksmc'] . '考试已经报名，请不要重复报名');
			return redirect('exam.listing');
		}

		if (DISABLE == $this->model->isAllowedRegister($type, $this->session->get('spno'), $this->session->get('college'))) {
			$this->session->put('error', $exam['ksmc'] . '考试不允许' . $this->session->get('speciality') . '专业学生报名');
			return redirect('exam.listing');
		}

		if (Config::get('exam.type.cet3') == $exam['kslx']) {
			if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet4'), $exam['sj'])) {
				$this->session->put('error', '已经报名本次CET4考试，CET4和英语应用能力B级不能同时报名');
				return redirect('exam.listing');
			}
		} elseif (Config::get('exam.type.cet4') == $exam['kslx']) {
			if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet3'), $exam['sj'])) {
				$this->session->put('error', '已经报名本次英语应用能力B级考试，英语应用能力B级CET4不能同时报名');
				return redirect('exam.listing');
			}

			if (!$this->model->isAllowedCET4AndCET6()) {
				if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet6'), $exam['sj'])) {
					$this->session->put('error', '已经报名本次CET6考试，CET6和CET4不能同时报名');
					return redirect('exam.listing');
				}
			}

			if (!$this->model->isAllowedFreshRegisterCET4()) {
				$student = new StudentModel();
				if ($student->isFresh($this->session->get('username') && !$student->isUndergraduate($this->session->get('username')))) {
					$this->session->put('error', '不允许新生报考CET4');
					return redirect('exam.listing');
				}
			}
		} elseif (Config::get('exam.type.cet6') == $exam['kslx']) {
			if (!$this->model->isAllowedCET4AndCET6()) {
				if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet4'), $exam['sj'])) {
					$this->session->put('error', '已经报名本次CET4考试，CET4和CET6不能同时报名');
					return redirect('exam.listing');
				}
			}

			if (!$this->model->isPassed($this->session->get('username'), Config::get('exam.type.cet4'))) {
				$this->session->put('error', 'CET4成绩不达标，不能参加CET6考试');
				return redirect('exam.listing');
			}
		}

		if (isPost()) {
			$_POST  = sanitize($_POST);
			$campus = $_POST['campus'];

			$this->model->register($this->session->get('username'), $type, $campus, $exam['sj']);

			return redirect('exam.listing');
		}

		$campus   = Dictionary::getAll('xqh');
		$campuses = array();
		foreach ($campus as $c) {
			if (!isEmpty($c['dm'])) {
				$campuses[$c['dm']] = $c['mc'];
			}
		}
		ksort($campuses);

		return $this->view->display('exam.register', array('type' => $type, 'exam' => $exam, 'campuses' => $campuses));
	}

	/**
	 * 列出考试报名信息
	 * @return void
	 */
	protected function listing() {
		$exams = $this->model->listRegister($this->session->get('username'));

		return $this->view->display('exam.listing', array('exams' => $exams));
	}

}