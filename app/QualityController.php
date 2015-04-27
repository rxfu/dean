<?php

/**
 * 教学质量监控类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class QualityController extends StudentAdminController {

	/**
	 * 列出当前学生、当前年度可评教课程
	 * @param  string $status 评教状态
	 * @return void
	 */
	protected function course($status) {
		$courses = $this->model->getCourses($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $status);

		return $this->view->display('quality.course', array('courses' => $courses, 'status' => $status));
	}

	/**
	 * 学生教学评价
	 * @param  string $cno    12位课程序号
	 * @param  string $status 评教状态
	 * @return void
	 */
	protected function assess($cno, $status) {
		$indexes        = $this->model->getIndexes();
		$ranks          = $this->model->getRanks();
		$data           = $this->model->getCourses($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $status, $cno);
		$course         = $data[0];
		$course['jsxm'] = implode(',', array_column($data, 'jsxm'));

		if (isPost()) {
			$_POST = sanitize($_POST);

			foreach ($indexes as $index) {
				$this->model->saveScore($this->session->get('year'),
					$this->session->get('term'),
					$this->session->get('username'),
					$course['kcxh'],
					$course['kch'],
					$index['ejzb_id'],
					$_POST['score' . $index['zb_id'] . $index['ejzb_id']]
				);
			}
			$this->model->saveComment($this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('username'),
				$course['kcxh'],
				$course['kch'],
				$_POST['advantage'],
				$_POST['shortcoming'],
				$_POST['word']
			);

			return redirect('quality.course', Config::get('quality.assessed'));
		}

		return $this->view->display('quality.assess', array('course' => $course, 'indexes' => $indexes, 'ranks' => $ranks));
	}

}