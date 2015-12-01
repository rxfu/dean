<?php

/**
 * 教师评学控制器
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class TasController extends TeacherAdminController {

	/**
	 * 录入教师评学数据
	 * @return void
	 */
	protected function input($cno) {
		$info = $this->model->getCourseInfo($this->session->get('year'), $this->session->get('term'), $cno);

		if (isPost()) {
			$_POST = sanitize($_POST);

			$this->model->save(
				$this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('username'),
				$info['kcxh'],
				$info['kkxy'],
				$info['zy'],
				$info['nj'],
				$_POST['scores']
			);

			Message::add('success', '评学成功');

			return redirect('tas.input', $cno);
		}

		$standards = $this->model->listResults($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $cno);

		return $this->view->display('tas.input', array('info' => $info, 'standards' => $standards));
	}

	protected function summary($year, $term) {
		$results = $this->model->listResults($year, $term, $this->session->get('username'));

		return $this->view->display('tas.summary', array('year' => $year, 'term' => $term, 'results' => $results));
	}

	protected function result($year, $term, $cno) {
		$info    = $this->model->getCourseInfo($year, $term, $cno);
		$results = $this->model->listResults($year, $term, $this->session->get('username'), $cno);

		return $this->view->display('tas.result', array('info' => $info, 'results' => $results));
	}

}