<?php

/**
 * 教师成绩管理类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class ScoreController extends TeacherAdminController {

	/**
	 * 禁止录入成绩
	 * @return  void
	 */
	protected function forbidden() {
		return $this->view->display('score.forbidden');
	}

	/**
	 * 教师录入成绩
	 * @param  string $cno 课程序号
	 * @return array          学生成绩
	 */
	protected function input($cno) {
		if ($this->model->isOpen()) {
			$info     = $this->model->getCourse($this->session->get('year'), $this->session->get('term'), $cno);
			$students = $this->model->getStudents($this->session->get('year'), $this->session->get('term'), $cno, $this->session->get('username'));
			foreach ($students as &$student) {
				if (isEmpty($student['tjzt'])) {
					$student['tjzt'] = Config::get('score.submit.uncommitted');
				}
			}

			$ratios = $this->model->getRatio($students[0]['cjfs']);
			$this->session->put('mode', $students[0]['cjfs']);
			$this->session->put('major_grade', max(array_keys($ratios['mode'])));

			$statuses = $this->model->getStatuses();

			return $this->view->display('score.input', array('info' => $info, 'students' => $students, 'ratios' => $ratios, 'report' => $students[0]['tjzt'], 'statuses' => $statuses));
		} else {
			return redirect('score.forbidden');
		}
	}

	/**
	 * 录入学生成绩，更新WEB成绩表
	 * @param  string $cno 课程序号
	 * @return boolean         成功返回TRUE，失败返回FALSE
	 */
	protected function enter($cno) {
		if ($this->model->isOpen()) {
			if (isPost()) {
				$_POST = sanitize($_POST);

				$sno   = $_POST['sno'];
				$mode  = substr($_POST['mode'], 5);
				$score = $_POST['score'];

				$ratios = $this->model->getRatio($this->session->get('mode'));

				// 计算总评成绩
				$grades               = $this->model->getScore($this->session->get('year'), $this->session->get('term'), $sno, $cno);
				$grades['cj' . $mode] = $score;
				$majorGrade           = $this->session->get('major_grade');
				if (Config::get('score.passline') > $grades['cj' . $majorGrade]) {
					$total = $grades['cj' . $majorGrade];
				} else {
					$total = 0;
					foreach ($ratios['mode'] as $key => $value) {
						$total += $grades['cj' . $key] * $value['bl'];
					}
					$total = round($total);
				}

				// 更新WEB成绩表
				$total = $this->model->enterScore($this->session->get('year'), $this->session->get('term'), $sno, $cno, $mode, $score, $total);
				if (isAjax()) {
					$response = $total ? array('success' => true, 'data' => $total) : array('success' => false);
					echo json_encode($response);
				}

				return $total;
			}
		} else {
			redirect('score.forbidden');
		}
	}

	/**
	 * 录入学生考试状态，更新WEB成绩表
	 * @param  string $cno 课程序号
	 * @return integer      成功返回影响行数，否则返回NULL
	 */
	protected function status($cno) {
		if ($this->model->isOpen()) {
			if (isPost()) {
				$_POST = sanitize($_POST);

				$sno    = $_POST['sno'];
				$status = $_POST['status'];

				// 更新WEB成绩表
				$updated = $this->model->modifyStatus($this->session->get('year'), $this->session->get('term'), $sno, $cno, $status);
			}
		} else {
			redirect('score.forbidden');
		}
	}

	/**
	 * 确认成绩
	 * @return boolean      确认成功为TRUE，否则为FALSE
	 */
	protected function confirm() {
		if ($this->model->isOpen()) {
			if (isPost()) {
				$_POST = sanitize($_POST);
				$cno   = $_POST['cno'];

				$this->model->confirmScore($this->session->get('year'), $this->session->get('term'), $cno);
				return redirect('score.input', $cno);
			}
		} else {
			return redirect('score.forbidden');
		}
	}

	/**
	 * 按年度按学期列出成绩单
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return array       成绩单列表
	 */
	protected function summary($year, $term) {
		$courses = $this->model->listCourses($year, $term, $this->session->get('username'));

		return $this->view->display('score.summary', array('courses' => $courses, 'year' => $year, 'term' => $term));
	}

	/**
	 * 列出课程成绩
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno 课程序号
	 * @return array         成绩列表
	 */
	protected function score($year, $term, $cno) {
		$info   = $this->model->getCourse($year, $term, $cno);
		$scores = $this->model->getReport($year, $term, $cno);
		$ratios = is_array($scores) ? $this->model->getRatio($scores[0]['cjfs']) : array();

		return $this->view->display('score.score', array('info' => $info, 'scores' => $scores, 'ratios' => $ratios));
	}

}
