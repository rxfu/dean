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

		$exam       = $this->model->getExamInfo($type);
		$registered = $this->model->isRegistered($this->session->get('username'), $type, $exam['nd']);

		if (!$registered) {
			if (in_array($exam['kslx'], array(Config::get('exam.type.cet4'), Config::get('exam.type.cjt4'), Config::get('exam.type.cft4'), Config::get('exam.type.crt4'), Config::get('exam.type.cgt4')))) {
				if (!$this->model->isAllowedFreshRegisterCET4()) {
					if ($student->isFresh($this->session->get('username')) && !$student->isUndergraduate($this->session->get('username'))) {
						Message::add('danger', '不允许新生报考' . $exam['ksmc'] . '考试');
						return redirect('exam.listing');
					}
				}
			}

			if (Config::get('exam.type.cet') == $exam['ksdl']) {
				if ($cet = $this->model->isRegisteredCET($this->session->get('username'), $exam['nd'])) {
					Message::add('danger', '已经报名本次' . $cet . '考试，' . $cet . '和' . $exam['ksmc'] . '不能同时报名');
					return redirect('exam.listing');
				}
			}

			if (Config::get('exam.type.cet6') == $exam['kslx']) {
				if (!$this->model->isPassed($this->session->get('username'), Config::get('exam.type.cet4'))) {
					Message::add('danger', 'CET4成绩不达标，不能参加CET6考试');
					return redirect('exam.listing');
				}
			}
		}

		if ($uploaded = $student->isUploadedPortrait($this->session->get('id'))) {
			if (isPost()) {
				$type = sanitize($_POST['type']);

				$this->model->register($this->session->get('username'), $type, $this->session->get('campus'), $exam['sj'], $exam['nd']);

				Message::add('success', '考试报名成功');

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

		$confirmed  = is_array($registered) ? $registered['clbz'] : false;
		$registered = is_array($registered) ? $registered['xq'] : false;

		return $this->view->display('exam.register', array('exam' => $exam, 'campuses' => $campuses, 'registered' => $registered, 'uploaded' => $uploaded, 'confirmed' => $confirmed));
	}

	/**
	 * 取消考试报名
	 * @return void
	 */
	protected function cancel() {
		if (isPost()) {
			$type = sanitize($_POST['type']);
			$exam = $this->model->getExamInfo($type);

			$deleted = $this->model->cancel($this->session->get('username'), $type, $exam['sj']);

			Message::add('success', '取消考试报名成功');
		}

		return redirect('exam.register', $type);
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
