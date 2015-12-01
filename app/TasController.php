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
		}

		$standards = $this->model->listStandards($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $cno);

		return $this->view->display('tas.input', array('info' => $info, 'standards' => $standards));
	}

}