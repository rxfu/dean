<?php

/**
 * 考试控制类
 */
class ExamController extends StudentAdminController {

	/**
	 * 学生考试报名
	 * @param  string $type 考试类型
	 * @return void
	 */
	protected function register($type) {
		$student = new StudentModel();

		$exam         = $this->model->getExamInfo($type);
		$isRegistered = $this->model->isRegistered($this->session->get('username'), $type, $exam['nd']);

		if (Config::get('exam.type.cet3') == $exam['kslx']) {
			if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet4'), $exam['nd'])) {
				Message::add('danger', '已经报名本次CET4考试，CET4和英语应用能力B级不能同时报名');
				return redirect('exam.listing');
			}

			if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet6'), $exam['nd'])) {
				Message::add('danger', '已经报名本次CET6考试，CET6和英语应用能力B级不能同时报名');
				return redirect('exam.listing');
			}
		} elseif (Config::get('exam.type.cet4') == $exam['kslx']) {
			if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet3'), $exam['nd'])) {
				Message::add('danger', '已经报名本次英语应用能力B级考试，英语应用能力B级和CET4不能同时报名');
				return redirect('exam.listing');
			}

			if (!$this->model->isAllowedCET4AndCET6()) {
				if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet6'), $exam['nd'])) {
					Message::add('danger', '已经报名本次CET6考试，CET6和CET4不能同时报名');
					return redirect('exam.listing');
				}
			}

			if (!$this->model->isAllowedFreshRegisterCET4()) {
				if ($student->isFresh($this->session->get('username') && !$student->isUndergraduate($this->session->get('username')))) {
					Message::add('danger', '不允许新生报考CET4');
					return redirect('exam.listing');
				}
			}
		} elseif (Config::get('exam.type.cet6') == $exam['kslx']) {
			if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet3'), $exam['nd'])) {
				Message::add('danger', '已经报名本次英语应用能力B级考试，英语应用能力B级和CET6不能同时报名');
				return redirect('exam.listing');
			}

			if (!$this->model->isAllowedCET4AndCET6()) {
				if ($this->model->isRegistered($this->session->get('username'), Config::get('exam.type.cet4'), $exam['nd'])) {
					Message::add('danger', '已经报名本次CET4考试，CET4和CET6不能同时报名');
					return redirect('exam.listing');
				}
			}

			if (!$this->model->isPassed($this->session->get('username'), Config::get('exam.type.cet4'))) {
				Message::add('danger', 'CET4成绩不达标，不能参加CET6考试');
				return redirect('exam.listing');
			}
		}

		if ($isUploaded = $student->isUploadedPortrait($this->session->get('id'))) {
			if (isPost()) {
				$_POST  = sanitize($_POST);
				$campus = $_POST['campus'];

				$this->model->register($this->session->get('username'), $type, $campus, $exam['sj'], $exam['nd']);

				return redirect('exam.register', $type);
			}
		}

		$campus   = Dictionary::getAll('xqh');
		$campuses = array();
		foreach ($campus as $c) {
			if (!isEmpty($c['dm'])) {
				$campuses[$c['dm']] = $c['mc'];
			}
		}
		ksort($campuses);

		return $this->view->display('exam.register', array('exam' => $exam, 'campuses' => $campuses, 'isRegistered' => $isRegistered, 'isUploaded' => $isUploaded));
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
